<?php

use App\Models\Team;
use App\Models\League;
use App\Models\Player;

test('team show screen can be rendered', function () {
    $team = Team::factory()->create();

    $response = $this->get(route('teams.show', $team));

    $response->assertOk();
});

test('team detail page displays team name and mascot', function () {
    $team = Team::factory()->create(['name' => 'Eagles', 'mascot' => 'Golden Eagle']);

    $response = $this->get(route('teams.show', $team));

    $response->assertOk()
        ->assertSeeText('Eagles')
        ->assertSeeText('Golden Eagle');
});

test('team detail page displays associated league link', function () {
    $league = League::factory()->create(['name' => 'Major League']);
    $team = Team::factory()->create(['league_id' => $league->id, 'name' => 'Test Team']);

    $response = $this->get(route('teams.show', $team));

    $response->assertOk()
        ->assertSeeText($league->name)
        ->assertSee(route('leagues.show', $league));
});

test('team detail page displays list of players on the team', function () {
    $team = Team::factory()->create();
    $player1 = Player::factory()->create(['team_id' => $team->id, 'first_name' => 'John', 'last_name' => 'Doe']);
    $player2 = Player::factory()->create(['team_id' => $team->id, 'first_name' => 'Jane', 'last_name' => 'Smith']);

    $response = $this->get(route('teams.show', $team));

    $response->assertOk()
        ->assertSeeText('John Doe')
        ->assertSeeText('Jane Smith')
        ->assertSee(route('players.show', $player1))
        ->assertSee(route('players.show', $player2));
});

test('team detail page has back to teams link', function () {
    $team = Team::factory()->create();

    $response = $this->get(route('teams.show', $team));

    $response->assertOk()
        ->assertSeeText('Back to Teams')
        ->assertSee(route('teams.index'));
});

test('team detail page shows empty state when no players', function () {
    $team = Team::factory()->create();

    $response = $this->get(route('teams.show', $team));

    $response->assertOk()
        ->assertSeeText('No players on this team yet');
});

test('team detail page only displays active players', function () {
    $team = Team::factory()->create();
    $activePlayers = Player::factory()->count(2)->create(['team_id' => $team->id, 'status' => 'Active']);
    $inactivePlayers = Player::factory()->count(2)->create(['team_id' => $team->id, 'status' => 'Inactive']);

    $response = $this->get(route('teams.show', $team));

    $response->assertOk();

    // Verify active players are displayed
    $activePlayers->each(function ($player) use ($response) {
        $response->assertSeeText($player->first_name);
    });

    // Verify inactive players are not displayed
    $inactivePlayers->each(function ($player) use ($response) {
        $response->assertDontSeeText($player->first_name);
    });
});

test('team detail page filters players by active scope', function () {
    $team = Team::factory()->create();
    $activePlayer = Player::factory()->create(['team_id' => $team->id, 'status' => 'Active', 'first_name' => 'Active', 'last_name' => 'Player']);
    $inactivePlayer = Player::factory()->create(['team_id' => $team->id, 'status' => 'Inactive', 'first_name' => 'Inactive', 'last_name' => 'Player']);

    $response = $this->get(route('teams.show', $team));

    expect($response->viewData('players'))->toHaveCount(1)
        ->and($response->viewData('players')->first()->id)->toBe($activePlayer->id);
});

test('team detail page orders players by first name', function () {
    $team = Team::factory()->create();
    $zoePlayer = Player::factory()->create(['team_id' => $team->id, 'first_name' => 'Zoe', 'last_name' => 'Smith']);
    $alicePlayer = Player::factory()->create(['team_id' => $team->id, 'first_name' => 'Alice', 'last_name' => 'Johnson']);
    $bobPlayer = Player::factory()->create(['team_id' => $team->id, 'first_name' => 'Bob', 'last_name' => 'Williams']);

    $response = $this->get(route('teams.show', $team));

    $players = $response->viewData('players');

    expect($players->pluck('first_name')->toArray())->toBe(['Alice', 'Bob', 'Zoe']);
});

test('team detail page passes league relationship to view', function () {
    $league = League::factory()->create(['name' => 'Test League']);
    $team = Team::factory()->create(['league_id' => $league->id]);

    $response = $this->get(route('teams.show', $team));

    $viewLeague = $response->viewData('league');

    expect($viewLeague)->toBeInstanceOf(League::class)
        ->and($viewLeague->id)->toBe($league->id)
        ->and($viewLeague->name)->toBe('Test League');
});

test('team detail page renders with team without mascot', function () {
    $team = Team::factory()->create(['mascot' => null]);

    $response = $this->get(route('teams.show', $team));

    $response->assertOk()
        ->assertViewHas('team', $team);
});
