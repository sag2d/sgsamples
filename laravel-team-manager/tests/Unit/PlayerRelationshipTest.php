<?php

use App\Models\Player;
use App\Models\State;
use App\Models\Team;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tests\TestCase;

uses(TestCase::class);

test('it belongs to a team and state', function () {
    $player = new Player;

    expect($player->team())
        ->toBeInstanceOf(BelongsTo::class)
        ->and($player->team()->getRelated())->toBeInstanceOf(Team::class)
        ->and($player->team()->getForeignKeyName())->toBe('team_id')
        ->and($player->state())->toBeInstanceOf(BelongsTo::class)
        ->and($player->state()->getRelated())->toBeInstanceOf(State::class)
        ->and($player->state()->getForeignKeyName())->toBe('state_id');
});
