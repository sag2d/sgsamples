<?php

use App\Models\Player;
use App\Models\Team;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;

uses(TestCase::class);

test('it belongs to a league', function () {
    $relation = (new Team)->league();

    expect($relation)
        ->toBeInstanceOf(BelongsTo::class)
        ->and($relation->getForeignKeyName())->toBe('league_id');
});

test('it has many players', function () {
    $relation = (new Team)->players();

    expect($relation)
        ->toBeInstanceOf(HasMany::class)
        ->and($relation->getRelated())->toBeInstanceOf(Player::class)
        ->and($relation->getForeignKeyName())->toBe('team_id');
});
