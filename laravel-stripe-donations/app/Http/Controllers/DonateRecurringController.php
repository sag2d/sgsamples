<?php

namespace App\Http\Controllers;

use App\Enums\DonationInterval;
use App\Enums\DonationStatus;
use App\Models\Donation;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Laravel\Cashier\Cashier;
use Laravel\Cashier\Exceptions\IncompletePayment;
use Laravel\Cashier\Subscription;

/**
 * Donate Recurring Controller for the Stripe Donations application.
 *
 * @author Scott Greenhagen
 */
class DonateRecurringController extends Controller
{
    /**
     * Display a recurring donation form for users to set up scheduled donations.
     */
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'amount' => ['sometimes', 'numeric', 'min:1', 'max:99999999'],
            'interval' => ['sometimes', Rule::enum(DonationInterval::class)],
        ]);
        $amount = number_format((float) ($validated['amount'] ?? 10), 2, '.', '');
        $interval = DonationInterval::from($validated['interval'] ?? DonationInterval::Month->value);
        $currency = strtolower(config('cashier.currency', 'usd'));
        $user = $request->user();

        // insert a new donation record with a status of pending, to be updated when the subscription is created
        $donation = $user->donations()->create([
            'donor_name' => $user->name,
            'donor_email' => $user->email,
            'amount' => $amount,
            'currency' => strtoupper($currency),
            'status' => DonationStatus::Pending,
            'interval' => $interval->value,
            'description' => 'Recurring Donation',
            'stripe_customer_id' => $user->stripe_id,
        ]);

        $options = [
            'payment_method_types' => ['card'],
            'description' => 'Recurring Donation',
            'metadata' => [
                'donation_id' => (string) $donation->getKey(),
                'user_id' => (string) $user->getKey(),
            ],
        ];

        // create a new Stripe SetupIntent for the user to set up a payment method for a recurring donation
        $setupIntent = $user->createSetupIntent($options);
        $setupCustomer = $setupIntent->customer;
        $customerId = is_string($setupCustomer) ? $setupCustomer : $setupCustomer?->id;

        if ($customerId !== null) {
            $donation->update(['stripe_customer_id' => $customerId]);
        }

        return view('account.donate-recurring', [
            'amount' => $amount,
            'interval' => $interval->value,
            'clientSecret' => $setupIntent->client_secret,
            'donationId' => $donation->getKey(),
        ]);
    }

    /**
     * Display the completion page for a recurring donation.
     */
    public function complete(Request $request): View|RedirectResponse
    {
        $validated = $request->validate([
            'donation_id' => ['required', 'integer', 'min:1'],
        ]);

        $user = $request->user();

        // find the donation record for the current user that matches the donation ID
        $donation = $user->donations()->findOrFail($validated['donation_id']);
        $completionRoute = route('donate-recurring.complete', ['donation_id' => $donation->getKey()]);

        if ($donation->subscription_id !== null) {
            // find the subscription for the current user that matches the donation's subscription ID
            $subscription = $user->subscriptions()->findOrFail($donation->subscription_id);
            $subscription->syncStripeStatus();

            if ($subscription->hasIncompletePayment()) {
                $latestPayment = $subscription->latestPayment();
                abort_if($latestPayment === null, 409, 'The recurring donation payment could not be confirmed.');

                return redirect()->route('cashier.payment', [
                    $latestPayment->id,
                    'redirect' => $completionRoute,
                ]);
            }

            abort_unless(in_array($subscription->stripe_status, ['active', 'trialing'], true), 409);

            // update the donation record to mark it as completed
            $donation->update(['status' => DonationStatus::Completed]);

            return view('account.donate-recurring-complete', ['donation' => $donation]);
        }

        $validatedSetupIntent = $request->validate([
            'setup_intent' => ['required', 'string', 'starts_with:seti_'],
        ]);
        $setupIntent = $user->findSetupIntent($validatedSetupIntent['setup_intent']);
        $metadataDonationId = $setupIntent->metadata->donation_id ?? null;
        $metadataUserId = $setupIntent->metadata->user_id ?? null;

        abort_unless((string) $metadataDonationId === (string) $donation->getKey(), 403);
        abort_unless((string) $metadataUserId === (string) $user->getKey(), 403);
        abort_unless($setupIntent->status === 'succeeded', 409, 'The payment method setup has not succeeded.');

        $setupCustomer = $setupIntent->customer;
        $setupCustomerId = is_string($setupCustomer) ? $setupCustomer : $setupCustomer?->id;

        if ($donation->stripe_customer_id !== null && $setupCustomerId !== null) {
            abort_unless($setupCustomerId === $donation->stripe_customer_id, 403);
        }

        $paymentMethod = $setupIntent->payment_method;
        $paymentMethodId = is_string($paymentMethod) ? $paymentMethod : $paymentMethod?->id;
        abort_unless(is_string($paymentMethodId) && $paymentMethodId !== '', 409);

        $amountStripe = (int) round((float) $donation->amount * 100);
        $interval = DonationInterval::from($donation->interval);
        $recurringProductId = env('STRIPE_RECURRING_PRODUCT_ID');
        
        // dynamically create a Stripe price for the recurring donation based on the amount and interval
        $stripePrice = Cashier::stripe()->prices->create([
            'unit_amount' => $amountStripe,
            'currency' => strtolower($donation->currency),
            'recurring' => ['interval' => $interval->value],
            'product' => $recurringProductId,
        ]);

        $subscriptionType = 'donation-'.$donation->getKey();

        // try to create a new subscription for the user with the specified payment method and price
        try {
            $subscription = $user->newSubscription($subscriptionType, $stripePrice->id)->create(
                $paymentMethodId,
                [],
                ['metadata' => ['donation_id' => (string) $donation->getKey()]],
            );
        } catch (IncompletePayment $exception) {
            $subscription = $user->subscription($subscriptionType);

            if ($subscription !== null) {
                $this->attachSubscription($donation, $subscription, $user, $paymentMethodId);
            } else {
                throw $exception;
            }

            return redirect()->route('cashier.payment', [
                $exception->payment->id,
                'redirect' => $completionRoute,
            ]);
        }

        // store the subscription details on the donation record and mark it as completed
        $this->attachSubscription($donation, $subscription, $user, $paymentMethodId);
        abort_unless(in_array($subscription->stripe_status, ['active', 'trialing'], true), 409);
        $donation->update(['status' => DonationStatus::Completed]);

        return view('account.donate-recurring-complete', ['donation' => $donation]);
    }

    /**
     * Store the Cashier subscription details on its donation record.
     */
    private function attachSubscription(Donation $donation, Subscription $subscription, User $user, string $paymentMethodId): void 
    {
        // update the donation record to store the subscription details
        $donation->update([
            'subscription_id' => $subscription->getKey(),
            'stripe_payment_method_id' => $paymentMethodId,
            'stripe_customer_id' => $user->stripe_id,
            'stripe_subscription_id' => $subscription->stripe_id,
        ]);
    }
}
