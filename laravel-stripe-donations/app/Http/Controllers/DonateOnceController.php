<?php

namespace App\Http\Controllers;

use App\Enums\DonationStatus;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

/**
 * Donate Once Controller for the Stripe Donations application.
 *
 * @author Scott Greenhagen
 */
class DonateOnceController extends Controller
{
    /**
     * Display a one-time donation form for users to make a single donation.
     */
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'amount' => ['sometimes', 'numeric', 'min:1', 'max:99999999'],
        ]);
        $amount = number_format((float) ($validated['amount'] ?? 10), 2, '.', '');
        $amountStripe = (int) round((float) $amount * 100);
        $user = $request->user();
        $currency = strtolower(config('cashier.currency', 'usd'));

        $options = [
            'currency' => $currency,
            'payment_method_types' => ['card'],
            'description' => 'One-Time Donation',
        ];

        $payment = $request->user()->pay($amountStripe, $options);

        // insert a new donation record with a status of pending, to be updated when the payment is completed
        $donation = $user->donations()->create([
            'donor_name' => $user->name,
            'donor_email' => $user->email,
            'amount' => $amount,
            'currency' => strtoupper($currency),
            'status' => DonationStatus::Pending,
            'description' => $options['description'],
            'stripe_customer_id' => $user->stripe_id,
            'stripe_payment_intent_id' => $payment->id,
        ]);

        return view('account.donate-once', [
            'amount' => $amount,
            'clientSecret' => $payment->client_secret,
            'donationId' => $donation->getKey(),
        ]);
    }

    /**
     * Display the completion page for a one-time donation.
     */
    public function complete(Request $request): View
    {
        $validated = $request->validate([
            'payment_intent' => ['required', 'string', 'starts_with:pi_'],
        ]);

        $user = $request->user();

        // find the donation record for the current user that matches the payment intent ID
        $donation = $user->donations()
            ->where('stripe_payment_intent_id', $validated['payment_intent'])
            ->firstOrFail();
        $paymentIntent = $user->stripe()->paymentIntents->retrieve($validated['payment_intent']);
        $customerId = is_string($paymentIntent->customer)
            ? $paymentIntent->customer
            : $paymentIntent->customer?->id;

        abort_unless($paymentIntent->status === 'succeeded', 409, 'The donation payment has not succeeded.');
        abort_unless($customerId === $donation->stripe_customer_id, 403);
        abort_unless((int) $paymentIntent->amount_received === (int) round((float) $donation->amount * 100), 409);
        abort_unless(strtoupper($paymentIntent->currency) === strtoupper($donation->currency), 409);

        $charge = $paymentIntent->latest_charge;
        $paymentMethod = $paymentIntent->payment_method;

        // update the donation record to mark it as completed and store the Stripe payment ID and payment method ID
        $donation->update([
            'status' => DonationStatus::Completed,
            'stripe_payment_id' => is_string($charge) ? $charge : $charge?->id,
            'stripe_payment_method_id' => is_string($paymentMethod) ? $paymentMethod : $paymentMethod?->id,
        ]);

        return view('account.donate-once-complete', ['donation' => $donation]);
    }
}
