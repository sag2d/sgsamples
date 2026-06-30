<?php

namespace App\Models;

use CodeIgniter\Model;

class TeamModel extends Model
{
    protected $table = 'teams';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = ['league_id', 'name', 'mascot'];

    /**
	 * Get One Team
	 * 
	 * This method gets a single team from the database, specified by ID.
	 * 
	 * @access public
	 * @param int $id
	 * @return mixed (Returns the team data if successful, or FALSE if the query failed.)
	 */
    public function getOneTeam(?int $id = null): object|false
    {
        if (empty($id)) {
            return false;
        }

        return $this->find($id) ?: false;
    }

    /**
	 * Get Teams
	 * 
	 * This method gets teams from the database.
	 * 
	 * @access public
	 * @return mixed (Returns the team data if successful, or FALSE if the query failed.)
	 */
    public function getTeams(): array|false
    {
        $rows = $this->orderBy('league_id', 'ASC')->findAll();

        return $rows ?: false;
    }

    public function getTeamOptions(bool $includePrompt = true): array
    {
        $options = $includePrompt ? ['' => 'Please Select One'] : [];
        $teams = $this->getTeams();

        if ($teams) {
            foreach ($teams as $team) {
                $options[$team->id] = $team->name;
            }
        }

        return $options;
    }
}
