<?php

use App\Models\State;
use App\Models\Player;
use Illuminate\Database\Eloquent\Relations\HasMany;

test('it has many players', function () {
    $state = State::factory()->create();
    
    $relation = $state->players();

    expect($relation)
        ->toBeInstanceOf(HasMany::class)
        ->and($relation->getRelated())->toBeInstanceOf(Player::class)
        ->and($relation->getForeignKeyName())->toBe('state_id');
});
