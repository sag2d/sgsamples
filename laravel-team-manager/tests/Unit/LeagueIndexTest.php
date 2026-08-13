<?php

use App\Http\Controllers\LeagueController;
use Illuminate\Support\Facades\Route;

test('it registers the leagues index route', function () {
    $route = Route::getRoutes()->getByName('leagues.index');

    expect($route)
        ->not->toBeNull()
        ->and($route->uri())->toBe('leagues')
        ->and($route->getActionName())->toBe(LeagueController::class.'@index');
});
