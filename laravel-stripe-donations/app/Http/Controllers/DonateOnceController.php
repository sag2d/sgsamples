<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

/**
 * Donate Once Controller for the Stripe Donations application.
 * 
 * @author Scott Greenhagen
 * @version 1.0
 * @package Stripe Donations
 */
class DonateOnceController extends Controller
{
    /**
     * Display a one-time donation form for users to make a single donation.
     */
    public function index(Request $request): View
    {
        $amount = 10 * 100; // Amount in cents (e.g., $10.00)
 
        $payment = $request->user()->pay($amount);

        /*
        // create pending donation record in the database
        $order = Order::create([
            'user_id' => $request->user()->id,
            'amount' => $amount,
            'status' => 'pending',
            'stripe_payment_intent_id' => $payment->id,
        ]);
        */

        return view('account.donate-once', [
            'clientSecret' => $payment->client_secret,
        ]);
    }

    /**
     * Display the completion page for a one-time donation.
     */
    public function complete(): View
    {
        /*
        // look up the donation record in the database and verify the payment status
        $order = Order::where('user_id', $request->user()->id)
        ->where('stripe_payment_intent_id', $request->payment_intent)
        ->firstOrFail();

        // retrieve the payment intent from Stripe to confirm the status
        $paymentIntent = $request->user()
        ->stripe()
        ->paymentIntents
        ->retrieve($request->payment_intent);

        if ($paymentIntent->customer === $request->user()->stripe_id) {
            if($paymentIntent->status === 'succeeded') {
                $order->update(['status' => 'paid']);
            } 
            else {
                $order->update(['status' => 'failed']); 
            }
        }
        */

        return view('account.donate-once-complete');
    }
}
