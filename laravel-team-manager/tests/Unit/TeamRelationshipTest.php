<?php

use App\Models\Player;
use App\Models\Team;
use Illuminate\Database\Eloquent\Relations\HasMany;

test('it has many players', function () {
    $relation = (new Team)->players();

    expect($relation)
        ->toBeInstanceOf(HasMany::class)
        ->and($relation->getRelated())->toBeInstanceOf(Player::class)
        ->and($relation->getForeignKeyName())->toBe('team_id');
});
