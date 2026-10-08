<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Laravel\Cashier\Cashier;

/**
 * Donate Recurring Controller for the Stripe Donations application.
 * 
 * @author Scott Greenhagen
 * @version 1.0
 * @package Stripe Donations
 */
class DonateRecurringController extends Controller
{
    /**
     * Display a recurring donation form for users to set up scheduled donations.
     */
    public function index(Request $request): View
    {
        // accept the amount from the query string, or default to $10
        $amount = request('amount', 10);
       
        /*
        // create pending donation record in the database
        $order = Order::create([
            'user_id' => $request->user()->id,
            'amount' => $amount,
            'status' => 'pending',
            'stripe_payment_intent_id' => $payment->id,
        ]);
        */

        // set the options for the Stripe setup intent
        $options = [
            'payment_method_types' => ['card'],
            'description' => 'Recurring Donation',
        ];

        // create the Stripe setup intent for the recurring donation
        $setupIntent = $request->user()->createSetupIntent($options);

        return view('account.donate-recurring', [
            'amount' => $amount,
            'clientSecret' => $setupIntent->client_secret,
        ]);
    }

    /**
     * Display the completion page for a recurring donation.
     */
    public function complete(Request $request): View
    {
        // accept the amount and interval from the query string, or default to $10 monthly
        $amount = request('amount', 10);
        $amountStripe = $amount * 100; // amount in cents
        $interval = request('interval', 'month'); // default to monthly recurring donation
        $recurringProductId = env('STRIPE_RECURRING_PRODUCT_ID'); // recurring product ID from the environment variable

        // create a Stripe price dynamically for the recurring donation
        $stripePrice = Cashier::stripe()->prices->create([
            'unit_amount' => $amountStripe,
            'currency' => config('cashier.currency', 'usd'),
            'recurring' => ['interval' => $interval],
            'product' => $recurringProductId,
        ]);

        // get the setup intent and payment method from the request
        $setupIntent = $request->user()->findSetupIntent($request->setup_intent);
        $paymentMethod = $setupIntent->payment_method;

        // create the recurring subscription for the user with the specified price and interval
        $request->user()->newSubscription('default', $stripePrice->id)->create($paymentMethod);

        return view('account.donate-recurring-complete');
    }
}
