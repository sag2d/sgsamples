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
#[CoversClass(\App\Controllers\Admin\Player::class)]
#[CoversFunction('get_states')]
#[CoversFunction('get_state_abbrs')]
final class AdminPlayerControllerTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    public function testIndexRendersAdminPlayerView(): void
    {
        if (! extension_loaded('mysqli')) {
            $this->markTestSkipped('The mysqli extension is required.');
        }

        $result = $this->get('/admin/player/index');

        $result->assertStatus(200);
    }

    #[CoversNothing]
    public function testEditRendersEditView(): void
    {
        if (! extension_loaded('mysqli')) {
            $this->markTestSkipped('The mysqli extension is required.');
        }

        $result = $this->get('/admin/player/edit');

        $result->assertStatus(200);
        $result->assertSee('Edit Player');
    }

    #[CoversNothing]
    public function testEditWithIdRendersExistingPlayer(): void
    {
        if (! extension_loaded('mysqli')) {
            $this->markTestSkipped('The mysqli extension is required.');
        }

        $result = $this->get('/admin/player/edit/1');

        $result->assertStatus(200);
    }

    public function testDeleteRedirectsToIndex(): void
    {
        if (! extension_loaded('mysqli')) {
            $this->markTestSkipped('The mysqli extension is required.');
        }

        $result = $this->get('/admin/player/delete/999999');

        $result->assertRedirect();
    }

    public function testSaveShowsValidationErrorWhenEmailIsEmpty(): void
    {
        if (! extension_loaded('mysqli')) {
            $this->markTestSkipped('The mysqli extension is required.');
        }

        $result = $this->post('/admin/player/save', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'team_id' => '1',
            'state_id' => '1',
            'email' => '',
            'phone' => '555-1234',
            'address' => '123 Main St',
            'city' => 'Springfield',
            'zip' => '12345',
        ]);

        $result->assertStatus(200);
        $result->assertSee('Edit Player');
        $result->assertSee('The Email field is required.');
    }

    public function testIndexPassesPlayersAndTeamsToView(): void
    {
        if (! extension_loaded('mysqli')) {
            $this->markTestSkipped('The mysqli extension is required.');
        }

        $result = $this->get('/admin/player/index');

        $result->assertStatus(200);
        $result->assertViewHas('players');
        $result->assertViewHas('teams');
    }

    public function testEditPassesStatesTeamsAndPlayer(): void
    {
        if (! extension_loaded('mysqli')) {
            $this->markTestSkipped('The mysqli extension is required.');
        }

        $result = $this->get('/admin/player/edit/1');

        $result->assertStatus(200);
        $result->assertViewHas('states');
        $result->assertViewHas('teams');
        $result->assertViewHas('player');
        $result->assertViewHas('errors');
    }
}
