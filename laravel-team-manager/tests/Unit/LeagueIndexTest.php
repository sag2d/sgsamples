<?php

use App\Http\Controllers\LeagueController;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

uses(TestCase::class);

test('it registers the leagues index route', function () {
    $route = Route::getRoutes()->getByName('leagues.index');

    expect($route)
        ->not->toBeNull()
        ->and($route->uri())->toBe('leagues')
        ->and($route->getActionName())->toBe(LeagueController::class.'@index');
});

test('it passes retrieved leagues to the index view', function () {
    $leagues = collect([(object) ['name' => 'Little League']]);
    $query = Mockery::mock();

    $query->shouldReceive('orderBy')->once()->with('name')->andReturnSelf();
    $query->shouldReceive('get')->once()->andReturn($leagues);

    Mockery::mock('alias:App\\Models\\League')
        ->shouldReceive('query')
        ->once()
        ->andReturn($query);

    $view = (new LeagueController)->index();

    expect($view->name())->toBe('leagues.index')
        ->and($view->getData()['leagues'])->toBe($leagues);
});

test('it renders leagues without authenticated user controls', function () {
    $view = view('leagues.index', [
        'leagues' => collect([(object) ['name' => 'Little League']]),
    ])->render();

    expect($view)
        ->toContain('Little League')
        ->not->toContain('Log out')
        ->not->toContain('Settings');
});
