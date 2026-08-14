<?php

use App\Models\Player;
use App\Models\State;
use App\Models\Team;

test('it generates a single player with required attributes', function () {
    $player = Player::factory()->make();

    expect($player)
        ->toBeInstanceOf(Player::class)
        ->and($player->first_name)->toBeString()->not->toBeEmpty()
        ->and($player->last_name)->toBeString()->not->toBeEmpty()
        ->and($player->email)->toBeString()->toContain('@')
        ->and($player->status)->toBe('Active');
});

test('it generates a player with associated team and state', function () {
    $player = Player::factory()->create();

    expect($player->team_id)->toBeInt()
        ->and($player->team)->toBeInstanceOf(Team::class)
        ->and($player->state_id)->toBeInt()
        ->and($player->state)->toBeInstanceOf(State::class);
});

test('it generates players with full contact information', function () {
    $player = Player::factory()->make();

    expect($player->address)->toBeString()->not->toBeEmpty()
        ->and($player->city)->toBeString()->not->toBeEmpty()
        ->and($player->zip)->toBeString()->not->toBeEmpty()
        ->and($player->phone)->toBeString()->not->toBeEmpty();
});

test('it generates players with unique emails', function () {
    $players = Player::factory()->count(5)->make();

    expect($players)
        ->toHaveCount(5)
        ->and($players->pluck('email')->unique())->toHaveCount(5);
});