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
#[CoversClass(\App\Controllers\Admin\League::class)]
final class AdminLeagueControllerTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    public function testIndexRendersAdminLeagueView(): void
    {
        if (! extension_loaded('mysqli')) {
            $this->markTestSkipped('The mysqli extension is required.');
        }

        $result = $this->get('/admin/league/index');

        $result->assertStatus(200);
    }

    public function testEditRendersEditView(): void
    {
        if (! extension_loaded('mysqli')) {
            $this->markTestSkipped('The mysqli extension is required.');
        }

        $result = $this->get('/admin/league/edit');

        $result->assertStatus(200);
        $result->assertSee('Edit League');
    }

    public function testEditWithIdRendersExistingLeague(): void
    {
        if (! extension_loaded('mysqli')) {
            $this->markTestSkipped('The mysqli extension is required.');
        }

        $result = $this->get('/admin/league/edit/1');

        $result->assertStatus(200);
    }

    public function testDeleteRedirectsToIndex(): void
    {
        if (! extension_loaded('mysqli')) {
            $this->markTestSkipped('The mysqli extension is required.');
        }

        $result = $this->get('/admin/league/delete/999999');

        $result->assertRedirect();
    }

    public function testEditPassesEmptyLeagueForCreate(): void
    {
        if (! extension_loaded('mysqli')) {
            $this->markTestSkipped('The mysqli extension is required.');
        }

        $result = $this->get('/admin/league/edit');

        $result->assertStatus(200);
        $result->assertViewHas('league');
        $result->assertViewHas('errors');
    }
}
