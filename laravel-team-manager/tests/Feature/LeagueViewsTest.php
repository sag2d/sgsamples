<?php

use App\Models\League;

test('league index screen can be rendered', function () {
    $response = $this->get(route('leagues.index'));

    $response->assertOk();
});

test('leagues are searchable by name', function () {
    League::factory()->create(['name' => 'Little League']);
    League::factory()->create(['name' => 'Major League']);
    League::factory()->create(['name' => 'Rookie League']);

    $response = $this->get(route('leagues.index', ['search' => 'Major']));

    $response->assertOk()
        ->assertViewIs('leagues.index')
        ->assertViewHas('searchName', 'Major');

    expect($response->viewData('leagues')->items())
        ->toHaveCount(1)
        ->and($response->viewData('leagues')->items()[0]->name)
        ->toBe('Major League');
});

test('search returns empty results when no leagues match', function () {
    League::factory()->create(['name' => 'Little League']);

    $response = $this->get(route('leagues.index', ['search' => 'NonExistent']));

    $response->assertOk();

    expect($response->viewData('leagues')->items())
        ->toHaveCount(0);
});

test('view contains links to league detail pages', function () {
    $league = League::factory()->create(['name' => 'Test League']);

    $response = $this->get(route('leagues.index'));

    $response->assertOk()
        ->assertSeeText('Test League')
        ->assertSee(route('leagues.show', $league));
});

test('view displays multiple league links correctly', function () {
    $league1 = League::factory()->create(['name' => 'League One']);
    $league2 = League::factory()->create(['name' => 'League Two']);

    $response = $this->get(route('leagues.index'));

    $response->assertOk()
        ->assertSeeText('League One')
        ->assertSeeText('League Two')
        ->assertSee(route('leagues.show', $league1))
        ->assertSee(route('leagues.show', $league2));
});

test('league detail link is clickable', function () {
    $league = League::factory()->create(['name' => 'Clickable League']);

    $response = $this->get(route('leagues.index'));

    $response->assertOk();
    
    // Follow the link to verify it works
    $detailResponse = $this->get(route('leagues.show', $league));
    
    expect($detailResponse->status())->toBe(200);
});
