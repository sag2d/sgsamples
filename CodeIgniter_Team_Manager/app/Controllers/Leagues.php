<?php

namespace App\Controllers;

use App\Models\LeagueModel;

class Leagues extends BaseController
{
    private LeagueModel $league;

    /**
     * Constructor
     *
     * @access public
     */
    public function __construct()
    {
        $this->league = new LeagueModel();
    }

    /**
     * Index
     *
     * This method loads the view to display league listing.
     *
     * @access public
     */
    public function index(): string
    {
        return $this->render('leagues/index', [
            'leagues' => $this->league->getLeagues(),
        ]);
    }

    /**
     * View
     *
     * This method loads the view to display an individual league's details.
     *
     * @access public
     * @param int|null $id
     */
    public function view(?int $id = null): string
    {
        return $this->render('leagues/view', [
            'league' => $this->league->getOneLeague($id),
        ]);
    }
}
