<?php

namespace App\Controllers;

use App\Models\LeagueModel;
use App\Models\TeamModel;

/**
 * Teams Controller for the frontend of the Team Manager application.
 * 
 * @author Scott Greenhagen
 * @version 2.0
 * @package Team Manager
 */
class Teams extends BaseController
{
    private LeagueModel $league;
    private TeamModel $team;

    /**
     * Constructor
     *
     * @access public
     */
    public function __construct()
    {
        $this->league = new LeagueModel();
        $this->team = new TeamModel();
    }

    /**
     * Index
     *
     * This method loads the view to display team listing.
     *
     * @access public
     * @return string
     */
    public function index(): string
    {
        return $this->render('teams/index', [
            'teams' => $this->team->getTeams(),
            'leagues' => $this->league->getLeagueOptions(false),
        ]);
    }

    /**
     * View
     *
     * This method loads the view to display an individual team's details.
     *
     * @access public
     * @param int|null $id
     * @return string
     */
    public function view(?int $id = null): string
    {
        $team = $this->team->getOneTeam($id);

        if (!$team) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return $this->render('teams/view', [
            'team' => $team,
            'league' => $this->league->getOneLeague((int) $team->league_id),
        ]);
    }
}
