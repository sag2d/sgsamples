<?php

use App\Models\Team;

test('it passes retrieved teams to the index view', function () {
    // Create test teams using factory
    Team::factory()->count(3)->create();

    $response = $this->get(route('teams.index'));

    $response->assertSuccessful()
        ->assertViewIs('teams.index')
        ->assertViewHas('teams')
        ->assertViewHas('searchName');

    // Check that all 3 teams are in the paginated result
    expect($response->viewData('teams')->items())
        ->toHaveCount(3);
});

test('it renders teams without authenticated user controls', function () {
    $team = Team::factory()->create(['name' => 'Eagles']);
    
    // Create a paginated collection to match what the view expects
    $teams = Team::paginate(10);
    
    $view = view('teams.index', [
        'teams' => $teams,
        'searchName' => '',
    ])->render();

    expect($view)
        ->toContain('Eagles')
        ->not->toContain('Log out')
        ->not->toContain('Settings');
});
