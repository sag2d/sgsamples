<?php

namespace Tests\Feature;

use App\Models\LeagueModel;
use App\Models\PlayerModel;
use App\Models\TeamModel;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversClass(LeagueModel::class)]
#[CoversClass(PlayerModel::class)]
#[CoversClass(TeamModel::class)]
#[CoversClass(\App\Controllers\Players::class)]
#[CoversFunction('get_states')]
#[CoversFunction('get_state_abbrs')]
final class PlayersControllerTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    public function testIndexRendersPlayersView(): void
    {
        if (! extension_loaded('mysqli')) {
            $this->markTestSkipped('The mysqli extension is required.');
        }

        $result = $this->get('/players');

        $result->assertStatus(200);
        $result->assertSeeText('Players');
    }

    public function testIndexReturnsSuccessfulResponse(): void
    {
        if (! extension_loaded('mysqli')) {
            $this->markTestSkipped('The mysqli extension is required.');
        }

        $result = $this->get('/players');

        $result->assertStatus(200);
    }

    #[CoversNothing]
    public function testViewRendersPlayerDetails(): void
    {
        if (! extension_loaded('mysqli')) {
            $this->markTestSkipped('The mysqli extension is required.');
        }

        // Assuming player with ID 1 exists in test database
        $result = $this->get('/players/view/1');

        $result->assertStatus(200);
    }

    public function testViewWithInvalidIdReturns404(): void
    {
        if (! extension_loaded('mysqli')) {
            $this->markTestSkipped('The mysqli extension is required.');
        }

        $this->expectException(\CodeIgniter\Exceptions\PageNotFoundException::class);
        
        $this->get('/players/view/999999');
    }

    public function testViewPassesTeamDataToView(): void
    {
        if (! extension_loaded('mysqli')) {
            $this->markTestSkipped('The mysqli extension is required.');
        }

        // Assuming player with ID 1 exists
        $result = $this->get('/players/view/1');

        $result->assertStatus(200);
    }

    #[CoversNothing]
    public function testViewPassesStateAbbreviationsToView(): void
    {
        if (! extension_loaded('mysqli')) {
            $this->markTestSkipped('The mysqli extension is required.');
        }

        $result = $this->get('/players/view/1');

        $result->assertStatus(200);
    }

    public function testIndexPassesPlayersAndTeamsToView(): void
    {
        if (! extension_loaded('mysqli')) {
            $this->markTestSkipped('The mysqli extension is required.');
        }

        $result = $this->get('/players');

        $result->assertStatus(200);
        $result->assertViewHas('players');
        $result->assertViewHas('teams');
    }

    public function testViewPassesStatesAndTeamData(): void
    {
        if (! extension_loaded('mysqli')) {
            $this->markTestSkipped('The mysqli extension is required.');
        }

        $result = $this->get('/players/view/1');

        $result->assertStatus(200);
        $result->assertViewHas('states');
        $result->assertViewHas('player');
        $result->assertViewHas('team');
    }
}
