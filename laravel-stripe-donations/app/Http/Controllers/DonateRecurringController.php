<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

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
        $amount = request('amount', 10);
        $amountStripe = $amount * 100; // amount in cents
 
        $payment = $request->user()->pay($amountStripe, [
            'currency' => 'usd',
            'payment_method_types' => ['card'],
            'description' => 'Recurring Donation',
        ]);

        /*
        // create pending donation record in the database
        $order = Order::create([
            'user_id' => $request->user()->id,
            'amount' => $amount,
            'status' => 'pending',
            'stripe_payment_intent_id' => $payment->id,
        ]);
        */

        $options = [
            'currency' => 'usd',
            'payment_method_types' => ['card'],
            'description' => 'Recurring Donation',
        ];

        return view('account.donate-recurring', [
            'amount' => $amount,
            'clientSecret' => $request->user()->createSetupIntent($options)->client_secret,
        ]);
    }

    /**
     * Display the completion page for a recurring donation.
     */
    public function complete(): View
    {
        /*
        $setupIntent = $request->user()->findSetupIntent(
            $request->setup_intent
        );
    
        $paymentMethod = $setupIntent->payment_method;
    
        $request->user()
            ->newSubscription('default', 'price_xxx')
            ->create($paymentMethod);
        */

        return view('account.donate-recurring-complete');
    }
}
