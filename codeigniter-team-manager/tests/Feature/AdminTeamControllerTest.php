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
#[CoversClass(\App\Controllers\Admin\Team::class)]
final class AdminTeamControllerTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    public function testIndexRendersAdminTeamView(): void
    {
        if (! extension_loaded('mysqli')) {
            $this->markTestSkipped('The mysqli extension is required.');
        }

        $result = $this->get('/admin/team/index');

        $result->assertStatus(200);
    }

    public function testEditRendersEditView(): void
    {
        if (! extension_loaded('mysqli')) {
            $this->markTestSkipped('The mysqli extension is required.');
        }

        $result = $this->get('/admin/team/edit');

        $result->assertStatus(200);
        $result->assertSee('Edit Team');
    }

    public function testEditWithIdRendersExistingTeam(): void
    {
        if (! extension_loaded('mysqli')) {
            $this->markTestSkipped('The mysqli extension is required.');
        }

        $result = $this->get('/admin/team/edit/1');

        $result->assertStatus(200);
    }

    public function testDeleteRedirectsToIndex(): void
    {
        if (! extension_loaded('mysqli')) {
            $this->markTestSkipped('The mysqli extension is required.');
        }

        $result = $this->get('/admin/team/delete/999999');

        $result->assertRedirect();
    }

    public function testSaveShowsValidationErrorWhenNameIsEmpty(): void
    {
        if (! extension_loaded('mysqli')) {
            $this->markTestSkipped('The mysqli extension is required.');
        }

        $result = $this->post('/admin/team/save', [
            'name' => '',
            'league_id' => '1',
            'mascot' => 'Tigers',
        ]);

        $result->assertStatus(200);
        $result->assertSee('Edit Team');
        $result->assertSee('The Name field is required.');
    }

    public function testIndexPassesTeamsAndLeaguesToView(): void
    {
        if (! extension_loaded('mysqli')) {
            $this->markTestSkipped('The mysqli extension is required.');
        }

        $result = $this->get('/admin/team/index');

        $result->assertStatus(200);
        $result->assertViewHas('teams');
        $result->assertViewHas('leagues');
    }
}
