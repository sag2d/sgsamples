<?php

test('homepage renders successfully', function () {
    $response = $this->get('/');

    $response->assertOk();
});

test('homepage contains link to leagues index', function () {
    $response = $this->get('/');

    $response->assertOk()
        ->assertSeeText('Leagues')
        ->assertSee(route('leagues.index'));
});

test('homepage contains link to teams index', function () {
    $response = $this->get('/');

    $response->assertOk()
        ->assertSeeText('Teams')
        ->assertSee(route('teams.index'));
});

test('homepage contains link to players index', function () {
    $response = $this->get('/');

    $response->assertOk()
        ->assertSeeText('Players')
        ->assertSee(route('players.index'));
});

test('homepage contains all three navigation links', function () {
    $response = $this->get('/');

    $response->assertOk()
        ->assertSee(route('leagues.index'))
        ->assertSee(route('teams.index'))
        ->assertSee(route('players.index'))
        ->assertSeeText('Leagues')
        ->assertSeeText('Teams')
        ->assertSeeText('Players');
});

test('homepage links navigate to correct pages', function () {
    $response = $this->get('/');
    
    $response->assertOk();
    
    // Verify each link navigates successfully
    $leaguesResponse = $this->get(route('leagues.index'));
    $teamsResponse = $this->get(route('teams.index'));
    $playersResponse = $this->get(route('players.index'));
    
    expect($leaguesResponse->status())->toBe(200)
        ->and($teamsResponse->status())->toBe(200)
        ->and($playersResponse->status())->toBe(200);
});
