<?php

use App\Models\League;

test('it generates a single league with a name', function () {
    $league = League::factory()->make();

    expect($league)
        ->toBeInstanceOf(League::class)
        ->and($league->name)->toBeString()
        ->and($league->name)->not->toBeEmpty();
});

test('it generates leagues with unique names', function () {
    $leagues = League::factory()->count(5)->make();

    expect($leagues)
        ->toHaveCount(5)
        ->and($leagues->pluck('name')->unique())->toHaveCount(5);
});
