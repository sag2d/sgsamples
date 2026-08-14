<?php

use App\Models\Player;
use App\Models\Team;
use App\Models\State;

test('player show screen can be rendered', function () {
    $player = Player::factory()->create();

    $response = $this->get(route('players.show', $player));

    $response->assertOk();
});

test('player detail page displays player name', function () {
    $player = Player::factory()->create(['first_name' => 'John', 'last_name' => 'Doe']);

    $response = $this->get(route('players.show', $player));

    $response->assertOk()
        ->assertSeeText('John Doe');
});

test('player detail page displays associated team link', function () {
    $team = Team::factory()->create(['name' => 'Eagles']);
    $player = Player::factory()->create(['team_id' => $team->id]);

    $response = $this->get(route('players.show', $player));

    $response->assertOk()
        ->assertSeeText('Eagles')
        ->assertSee(route('teams.show', $team));
});

test('player detail page displays address information', function () {
    $state = State::factory()->create(['name' => 'California', 'abbr' => 'CA']);
    $player = Player::factory()->create([
        'address' => '123 Main St',
        'city' => 'Los Angeles',
        'state_id' => $state->id,
        'zip' => '90001',
    ]);

    $response = $this->get(route('players.show', $player));

    $response->assertOk()
        ->assertSeeText('123 Main St')
        ->assertSeeText('Los Angeles')
        ->assertSeeText('CA')
        ->assertSeeText('90001');
});

test('player detail page has back to players link', function () {
    $player = Player::factory()->create();

    $response = $this->get(route('players.show', $player));

    $response->assertOk()
        ->assertSeeText('Back to Players')
        ->assertSee(route('players.index'));
});
