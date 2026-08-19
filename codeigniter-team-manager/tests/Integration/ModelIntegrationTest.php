<?php

namespace Tests\Integration;

use App\Models\LeagueModel;
use App\Models\PlayerModel;
use App\Models\TeamModel;
use CodeIgniter\Test\CIUnitTestCase;
use Config\Database;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversFunction;
use Throwable;

#[CoversClass(LeagueModel::class)]
#[CoversClass(PlayerModel::class)]
#[CoversClass(TeamModel::class)]
#[CoversFunction('get_states')]
#[CoversFunction('get_state_abbrs')]
final class ModelIntegrationTest extends CIUnitTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        try {
            $this->db = Database::connect();
            $this->db->initialize();

            foreach (['leagues', 'teams', 'players', 'states'] as $table) {
                if (! $this->db->tableExists($table)) {
                    $this->markTestSkipped("Database table '{$table}' is not available.");
                }
            }
        } catch (Throwable $exception) {
            $this->markTestSkipped('Database is not available: ' . $exception->getMessage());
        }
    }

    public function testModelsReadSeededRecords(): void
    {
        $league = (new LeagueModel())->getOneLeague(1);
        $team = (new TeamModel())->getOneTeam(1);
        $player = (new PlayerModel())->getOnePlayer(1);

        $this->assertIsObject($league);
        $this->assertSame('Little League', $league->name);
        $this->assertIsObject($team);
        $this->assertSame('Tigers', $team->name);
        $this->assertIsObject($player);
        $this->assertSame('Billy', $player->first_name);
    }

    public function testModelOptionListsIncludeSeededNames(): void
    {
        $leagueOptions = (new LeagueModel())->getLeagueOptions();
        $teamOptions = (new TeamModel())->getTeamOptions();

        $this->assertSame('Please Select One', $leagueOptions['']);
        $this->assertContains('Little League', $leagueOptions);
        $this->assertSame('Please Select One', $teamOptions['']);
        $this->assertContains('Tigers', $teamOptions);
    }

    public function testStateHelpersReadSeededStates(): void
    {
        helper('state');

        $states = get_states();
        $abbreviations = get_state_abbrs();

        $this->assertIsArray($states);
        $this->assertSame('ILLINOIS', $states[14]);
        $this->assertIsArray($abbreviations);
        $this->assertSame('IL', $abbreviations[14]);
    }
}
