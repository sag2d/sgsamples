<?php

use App\Models\Player;

test('it passes retrieved players to the index view', function () {
    // Create test players using factory
    Player::factory()->count(3)->create();

    $response = $this->get(route('players.index'));

    $response->assertSuccessful()
        ->assertViewIs('players.index')
        ->assertViewHas('players')
        ->assertViewHas('searchName');

    // Check that all 3 players are in the paginated result
    expect($response->viewData('players')->items())
        ->toHaveCount(3);
});

test('it renders players without authenticated user controls', function () {
    $player = Player::factory()->create(['first_name' => 'John', 'last_name' => 'Smith']);
    
    // Create a paginated collection to match what the view expects
    $players = Player::paginate(10);
    
    $view = view('players.index', [
        'players' => $players,
        'searchName' => '',
    ])->render();

    expect($view)
        ->toContain('John')
        ->not->toContain('Log out')
        ->not->toContain('Settings');
});
