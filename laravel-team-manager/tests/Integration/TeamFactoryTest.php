<?php

use App\Models\League;
use App\Models\Team;

test('it generates a single team with required attributes', function () {
    $team = Team::factory()->make();

    expect($team)
        ->toBeInstanceOf(Team::class)
        ->and($team->name)->toBeString()->not->toBeEmpty()
        ->and($team->mascot)->toBeString()->not->toBeEmpty();
});

test('it generates a team with an associated league', function () {
    $team = Team::factory()->create();

    expect($team->league_id)->toBeInt()
        ->and($team->league)->toBeInstanceOf(League::class);
});

test('it generates teams with league, name, and mascot', function () {
    $teams = Team::factory()->count(5)->make();

    expect($teams)
        ->toHaveCount(5)
        ->and($teams->pluck('name')->unique())->toHaveCount(5)
        ->and($teams->pluck('mascot')->unique())->toHaveCount(5);
});
