<?php

use App\Models\League;

test('it passes retrieved leagues to the index view', function () {
    // Create test leagues using factory
    League::factory()->count(3)->create();

    $response = $this->get(route('leagues.index'));

    $response->assertSuccessful()
        ->assertViewIs('leagues.index')
        ->assertViewHas('leagues')
        ->assertViewHas('searchName');

    // Check that all 3 leagues are in the paginated result
    expect($response->viewData('leagues')->items())
        ->toHaveCount(3);
});

test('it renders leagues without authenticated user controls', function () {
    $league = League::factory()->create(['name' => 'Little League']);
    
    // Create a paginated collection to match what the view expects
    $leagues = League::paginate(10);
    
    $view = view('leagues.index', [
        'leagues' => $leagues,
        'searchName' => '',
    ])->render();

    expect($view)
        ->toContain('Little League')
        ->not->toContain('Log out')
        ->not->toContain('Settings');
});
