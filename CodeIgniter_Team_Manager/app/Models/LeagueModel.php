<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * League Model for the Team Manager application.
 * 
 * @author Scott Greenhagen
 * @version 2.0
 * @package Team Manager
 */
class LeagueModel extends Model
{
    protected $table = 'leagues';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = ['name'];

    /**
	 * Get One League
	 * 
	 * This method gets a single league from the database, specified by ID.
	 * 
	 * @access public
	 * @param int $id
	 * @return mixed (Returns the league data if successful, or FALSE if the query failed.)
	 */
    public function getOneLeague(?int $id = null): object|false
    {
        if (empty($id)) {
            return false;
        }

        return $this->find($id) ?: false;
    }

    /**
	 * Get Leagues
	 * 
	 * This method gets leagues from the database.
	 * 
	 * @access public
	 * @return mixed (Returns the league data if successful, or FALSE if the query failed.)
	 */
    public function getLeagues(): array|false
    {
        $rows = $this->orderBy('name', 'ASC')->findAll();

        return $rows ?: false;
    }

    /**
     * Get League Options
     * 
     * This method gets leagues from the database and returns them in an array 
     * suitable for use in a dropdown menu.
     *
     * @access public
     * @param bool $includePrompt (Whether to include a prompt option at the top of the list.)
     * @return array
     */
    public function getLeagueOptions(bool $includePrompt = true): array
    {
        $options = $includePrompt ? ['' => 'Please Select One'] : [];
        $leagues = $this->getLeagues();

        if ($leagues) {
            foreach ($leagues as $league) {
                $options[$league->id] = $league->name;
            }
        }

        return $options;
    }
}
