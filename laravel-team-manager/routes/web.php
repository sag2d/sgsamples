<?php

use App\Http\Controllers\LeagueController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::get('/leagues', [LeagueController::class, 'index'])->name('leagues.index');
Route::get('/leagues/{league}', [LeagueController::class, 'show'])->name('leagues.show');

Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');
Route::get('/teams/{team}', [TeamController::class, 'show'])->name('teams.show');

Route::get('/players', [PlayerController::class, 'index'])->name('players.index');
Route::get('/players/{player}', [PlayerController::class, 'show'])->name('players.show');

/*
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});
*/

require __DIR__.'/settings.php';
