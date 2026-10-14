<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Stripe\Exception\ApiErrorException;

/**
 * Donation Controller to view donation history and manage recurring donations.
 *
 * @author Scott Greenhagen
 */
class DonationController extends Controller
{
    /**
     * Display a listing of the current user's donations that are not pending.
     */
    public function index(Request $request): View
    {
        $donations = $request->user()
            ->donations()
            ->notPending()
            ->with('subscription')
            ->latest()
            ->paginate(10);

        return view('account.donation-history', ['donations' => $donations]);
    }

    /**
     * Schedule cancellation for one of the current user's active recurring donations.
     */
    public function cancel(Request $request, Donation $donation): RedirectResponse
    {
        $donation = $request->user()
            ->donations()
            ->with('subscription')
            ->findOrFail($donation->getKey());
        $subscription = $donation->subscription;

        abort_unless($subscription !== null && $donation->interval !== null, 404);

        try {
            $subscription->syncStripeStatus();

            abort_unless($subscription->active() && ! $subscription->canceled(), 409, 'This recurring donation is not active.');

            if (! in_array($subscription->stripe_status, ['active', 'trialing'], true)
                || ! $subscription->active()
                || $subscription->canceled()) {
                
                return redirect()
                    ->route('donation-history')
                    ->with('status', __('This recurring donation is no longer active.'));
            }

            $subscription->cancel();
        } catch (ApiErrorException $exception) {
            report($exception);

            return redirect()
                ->route('donation-history')
                ->with('error', __('Stripe could not cancel this subscription. It may have already been canceled.'));
        }

        return redirect()
            ->route('donation-history')
            ->with('status', __('Your recurring donation has been scheduled for cancellation.'));
    }
}
