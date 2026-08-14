<?php

use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

test('it registers the team index route', function () {
    $route = Route::getRoutes()->getByName('teams.index');

    expect($route)
        ->not->toBeNull()
        ->and($route->uri())->toBe('teams')
        ->and($route->getActionName())->toBe(TeamController::class.'@index');
});
