<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonateOnceController;
use App\Http\Controllers\DonateRecurringController;
use App\Http\Controllers\DonationController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

// Frontend login-protected route for authenticated users to access dashboard features
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/account/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // route to allow users to choose between one-time and recurring donation options and amounts
    Route::view('/account/donate', 'account.donate')->name('donate');

    // one-time donation form route for users to make a single donation
    Route::get('/account/donate-once', [DonateOnceController::class, 'index'])->name('donate-once');
    Route::get('/account/donate-once/complete', [DonateOnceController::class, 'complete'])->name('donate-once.complete');

    // recurring donation routes for users to set up scheduled donations
    Route::get('/account/donate-recurring', [DonateRecurringController::class, 'index'])->name('donate-recurring');
    Route::get('/account/donate-recurring/complete', [DonateRecurringController::class, 'complete'])->name('donate-recurring.complete');

    // route to allow users to view their donation history, transaction details, and cancel recurring donations
    Route::get('/account/donation-history', [DonationController::class, 'index'])->name('donation-history');
    Route::post('/account/donation-history/{donation}/cancel', [DonationController::class, 'cancel'])
        ->name('donation-history.cancel');
});

require __DIR__.'/settings.php';
