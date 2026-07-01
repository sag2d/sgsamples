<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Player Model for the Team Manager application.
 * 
 * @author Scott Greenhagen
 * @version 2.0
 * @package Team Manager
 */
class PlayerModel extends Model
{
    protected $table = 'players';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = [
        'team_id',
        'first_name',
        'last_name',
        'address',
        'city',
        'state_id',
        'zip',
        'email',
        'phone',
    ];

    /**
	 * Get One Player
	 * 
	 * This method gets a single player from the database, specified by ID.
	 * 
	 * @access public
	 * @param int $id
	 * @return mixed (Returns the player data if successful, or FALSE if the query failed.)
	 */
    public function getOnePlayer(?int $id = null): object|false
    {
        if (empty($id)) {
            return false;
        }

        return $this->find($id) ?: false;
    }

    /**
	 * Get Players
	 * 
	 * This method gets players from the database.
	 * 
	 * @access public
	 * @return mixed (Returns the player data if successful, or FALSE if the query failed.)
	 */
    public function getPlayers(): array|false
    {
        $rows = $this->orderBy('first_name', 'ASC')->findAll();

        return $rows ?: false;
    }
}
