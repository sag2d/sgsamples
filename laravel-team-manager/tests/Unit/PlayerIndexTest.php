<?php

use App\Http\Controllers\PlayerController;
use Illuminate\Support\Facades\Route;

test('it registers the player index route', function () {
    $route = Route::getRoutes()->getByName('players.index');

    expect($route)
        ->not->toBeNull()
        ->and($route->uri())->toBe('players')
        ->and($route->getActionName())->toBe(PlayerController::class.'@index');
});
