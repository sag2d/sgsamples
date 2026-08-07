<?php

use App\Models\Player;
use App\Models\State;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;

uses(TestCase::class);

test('it has many players', function () {
    $relation = (new State)->players();

    expect($relation)
        ->toBeInstanceOf(HasMany::class)
        ->and($relation->getRelated())->toBeInstanceOf(Player::class)
        ->and($relation->getForeignKeyName())->toBe('state_id');
});
