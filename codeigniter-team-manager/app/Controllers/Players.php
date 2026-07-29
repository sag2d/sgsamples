<?php

namespace App\Controllers;

use App\Models\PlayerModel;
use App\Models\TeamModel;

/**
 * Players Controller for the frontend of the Team Manager application.
 * 
 * @author Scott Greenhagen
 * @version 2.0
 * @package Team Manager
 */
class Players extends BaseController
{
    private PlayerModel $player;
    private TeamModel $team;

    /**
     * Constructor
     *
     * @access public
     */
    public function __construct()
    {
        $this->player = new PlayerModel();
        $this->team = new TeamModel();
    }

    /**
     * Index
     *
     * This method loads the view to display player listing.
     *
     * @access public
     * @return string
     */
    public function index(): string
    {
        return $this->render('players/index', [
            'players' => $this->player->getPlayers(),
            'teams' => $this->team->getTeamOptions(false),
        ]);
    }

    /**
     * View
     *
     * This method loads the view to display an individual player's details.
     *
     * @access public
     * @param int|null $id
     * @return string
     */
    public function view(?int $id = null): string
    {
        $player = $this->player->getOnePlayer($id);

        return $this->render('players/view', [
            'states' => get_state_abbrs(),
            'player' => $player,
            'team' => $player ? $this->team->getOneTeam((int) $player->team_id) : false,
        ]);
    }
}
