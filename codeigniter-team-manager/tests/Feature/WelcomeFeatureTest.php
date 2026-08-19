<?php

namespace Tests\Feature;

use App\Models\TeamModel;
use App\Models\LeagueModel;
use App\Models\PlayerModel;
use App\Controllers\Admin\League;
use App\Controllers\Admin\Team;
use App\Controllers\Admin\Player;
use App\Controllers\BaseController;
use App\Controllers\Welcome;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversFunction;

#[CoversClass(BaseController::class)]
#[CoversClass(Welcome::class)]
#[CoversClass(LeagueModel::class)]
#[CoversClass(TeamModel::class)]
#[CoversClass(PlayerModel::class)]
#[CoversClass(League::class)]
#[CoversClass(Team::class)]
#[CoversClass(Player::class)]
#[CoversFunction('get_states')]
#[CoversFunction('get_state_abbrs')]
final class WelcomeFeatureTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    public function testHomePageShowsTeamManagerNavigation(): void
    {
        $result = $this->get('/');

        $result->assertOK();
        $result->assertSee('Team Manager');
        $result->assertSee('View Leagues');
        $result->assertSee('Manage Players');
    }

    public function testLeagueSaveShowsValidationErrorsWhenNameIsMissing(): void
    {
        if (! extension_loaded('mysqli')) {
            $this->markTestSkipped('The mysqli extension is required for admin model initialization.');
        }

        $result = $this->post('/admin/league/save', ['name' => '']);

        $result->assertStatus(200);
        $result->assertSee('Edit League');
        $result->assertSee('The Name field is required.');
    }

    public function testTeamSaveShowsValidationErrorsWhenNameIsMissing(): void
    {
        if (! extension_loaded('mysqli')) {
            $this->markTestSkipped('The mysqli extension is required for admin model initialization.');
        }

        $result = $this->post('/admin/team/save', ['name' => '', 'league_id' => '']);

        $result->assertStatus(200);
        $result->assertSee('Edit Team');
        $result->assertSee('The Name field is required.');
    }

    public function testTeamSaveShowsValidationErrorsWhenLeagueIsMissing(): void
    {
        if (! extension_loaded('mysqli')) {
            $this->markTestSkipped('The mysqli extension is required for admin model initialization.');
        }

        $result = $this->post('/admin/team/save', ['name' => 'Test Team', 'league_id' => '']);

        $result->assertStatus(200);
        $result->assertSee('Edit Team');
        $result->assertSee('The League field is required.');
    }

    public function testPlayerSaveShowsValidationErrorsWhenFirstNameIsMissing(): void
    {
        if (! extension_loaded('mysqli')) {
            $this->markTestSkipped('The mysqli extension is required for admin model initialization.');
        }

        $result = $this->post('/admin/player/save', [
            'first_name' => '',
            'last_name' => 'Smith',
            'team_id' => '',
            'state_id' => '',
            'email' => 'test@example.com',
        ]);

        $result->assertStatus(200);
        $result->assertSee('Edit Player');
        $result->assertSee('The First Name field is required.');
    }

    public function testPlayerSaveShowsValidationErrorsWhenEmailIsInvalid(): void
    {
        if (! extension_loaded('mysqli')) {
            $this->markTestSkipped('The mysqli extension is required for admin model initialization.');
        }

        $result = $this->post('/admin/player/save', [
            'first_name' => 'John',
            'last_name' => 'Smith',
            'team_id' => '',
            'state_id' => '',
            'email' => 'invalid-email',
        ]);

        $result->assertStatus(200);
        $result->assertSee('Edit Player');
        $result->assertSee('The Email field must contain a valid email address.');
    }
}
