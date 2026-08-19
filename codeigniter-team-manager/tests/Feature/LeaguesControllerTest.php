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
#[CoversClass(\App\Controllers\Leagues::class)]
final class LeaguesControllerTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    public function testIndexRendersLeaguesView(): void
    {
        if (! extension_loaded('mysqli')) {
            $this->markTestSkipped('The mysqli extension is required.');
        }

        $result = $this->get('/leagues');

        $result->assertStatus(200);
        $result->assertSeeText('Leagues');
    }

    public function testIndexReturnsSuccessfulResponse(): void
    {
        if (! extension_loaded('mysqli')) {
            $this->markTestSkipped('The mysqli extension is required.');
        }

        $result = $this->get('/leagues');

        $result->assertStatus(200);
    }

    public function testViewRendersLeagueDetails(): void
    {
        if (! extension_loaded('mysqli')) {
            $this->markTestSkipped('The mysqli extension is required.');
        }

        // Assuming league with ID 1 exists in test database
        $result = $this->get('/leagues/view/1');

        $result->assertStatus(200);
    }

    public function testViewRendersLeagueDetailsWithValidId(): void
    {
        if (! extension_loaded('mysqli')) {
            $this->markTestSkipped('The mysqli extension is required.');
        }

        $result = $this->get('/leagues/view/1');
        
        $result->assertStatus(200);
    }

    public function testIndexPassesLeaguesToView(): void
    {
        if (! extension_loaded('mysqli')) {
            $this->markTestSkipped('The mysqli extension is required.');
        }

        $result = $this->get('/leagues');

        $result->assertStatus(200);
        $result->assertViewHas('leagues');
    }

}
