<?php

use App\Models\Team;
use App\Models\Player;
use App\Models\State;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

test('it belongs to a team and state', function () {
    $player = Player::factory()->create();
    
    $relation = $player->team();

    expect($relation)
        ->toBeInstanceOf(BelongsTo::class)
        ->and($relation->getRelated())->toBeInstanceOf(Team::class)
        ->and($relation->getForeignKeyName())->toBe('team_id')
        ->and($player->state())->toBeInstanceOf(BelongsTo::class)
        ->and($player->state()->getRelated())->toBeInstanceOf(State::class)
        ->and($player->state()->getForeignKeyName())->toBe('state_id');
});
