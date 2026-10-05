<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DonateOnceController;

Route::view('/', 'welcome')->name('home');

// Frontend login route for authenticated users to access dashboard features
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/account/dashboard', 'account.dashboard')->name('dashboard');

    Route::get('/account/donate-once', [DonateOnceController::class, 'index'])->name('donate-once');
    Route::get('/account/donate-once/complete', [DonateOnceController::class, 'complete'])->name('donate-once.complete');
});

require __DIR__.'/settings.php';
