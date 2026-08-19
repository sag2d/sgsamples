<?php

namespace Tests\Feature;

use App\Models\LeagueModel;
use App\Models\PlayerModel;
use App\Models\TeamModel;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(LeagueModel::class)]
#[CoversClass(PlayerModel::class)]
#[CoversClass(TeamModel::class)]
#[CoversClass(\App\Controllers\Teams::class)]
final class TeamsControllerTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    public function testIndexRendersTeamsView(): void
    {
        if (! extension_loaded('mysqli')) {
            $this->markTestSkipped('The mysqli extension is required.');
        }

        $result = $this->get('/teams');

        $result->assertStatus(200);
        $result->assertSeeText('Teams');
    }

    public function testIndexReturnsSuccessfulResponse(): void
    {
        if (! extension_loaded('mysqli')) {
            $this->markTestSkipped('The mysqli extension is required.');
        }

        $result = $this->get('/teams');

        $result->assertStatus(200);
    }

    public function testViewRendersTeamDetails(): void
    {
        if (! extension_loaded('mysqli')) {
            $this->markTestSkipped('The mysqli extension is required.');
        }

        // Assuming team with ID 1 exists in test database
        $result = $this->get('/teams/view/1');

        $result->assertStatus(200);
    }

    public function testViewWithInvalidIdReturns404(): void
    {
        if (! extension_loaded('mysqli')) {
            $this->markTestSkipped('The mysqli extension is required.');
        }

        $this->expectException(\CodeIgniter\Exceptions\PageNotFoundException::class);
        
        $this->get('/teams/view/999999');
    }

    public function testViewPassesLeagueDataToView(): void
    {
        if (! extension_loaded('mysqli')) {
            $this->markTestSkipped('The mysqli extension is required.');
        }

        // Assuming team with ID 1 exists
        $result = $this->get('/teams/view/1');

        $result->assertStatus(200);
    }

    public function testIndexPassesTeamsAndLeaguesToView(): void
    {
        if (! extension_loaded('mysqli')) {
            $this->markTestSkipped('The mysqli extension is required.');
        }

        $result = $this->get('/teams');

        $result->assertStatus(200);
        $result->assertViewHas('teams');
        $result->assertViewHas('leagues');
    }
}
