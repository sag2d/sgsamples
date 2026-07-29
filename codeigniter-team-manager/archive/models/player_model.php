<?php if( !defined('BASEPATH') ) exit('No direct script access allowed');

/**
 * Player Model
 * 
 * @author Scott Greenhagen
 * @version 1.0
 * @package Team Manager
 */
class Player_model extends CI_Model
{
	var $id;
	var $team_id;
	var $first_name;
	var $last_name;
	var $address;
	var $city;
	var $state_id;
	var $zip;
	var $email;
	var $phone;
	
	/**
	 * Insert Player
	 * 
	 * This method inserts a new player into the database.	
	 * 
	 * @access public
	 * @return mixed (Returns the record ID if the insert was successful, or FALSE if it failed.)
	 */
	public function insert_player()
	{		
		$this->db->insert('players', $this);
		
		if($this->db->insert_id() > 0)
		{
			return $this->db->insert_id();
		}
		else
		{
			return FALSE;
		}
	}
	
	/**
	 * Get One Player
	 * 
	 * This method gets a single player from the database, specified by ID.
	 * 
	 * @access public
	 * @param int $id
	 * @return mixed (Returns the player data if successful, or FALSE if the query failed.)
	 */
	public function get_one_player($id = NULL)
	{
		// return if no ID, or if ID is not a number.
		if(empty($id) || !is_numeric($id))
		{
			return FALSE;
		}
		
		$this->db->where('id', $id);
		$query = $this->db->get('players');
		
		if($query->num_rows() > 0)
		{
			return $query->row();
		}
		else
		{
			return FALSE;
		}		
	}
	
	/**
	 * Get Players
	 * 
	 * This method gets players from the database.
	 * 
	 * @access public
	 * @return mixed (Returns the player data if successful, or FALSE if the query failed.)
	 */
	public function get_players()
	{
		$this->db->order_by('team_id', 'ASC');
		$query = $this->db->get('players');
		
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}		
	}
	
	/**
	 * Update Player
	 * 
	 * This method updates a player in the database.
	 * 
	 * @access public
	 * @return bool (Returns TRUE if the update was successful, or FALSE if the query failed.)
	 */
	public function update_player()
	{	
		// return if no ID, or if ID is not a number.
		if(empty($this->id) || !is_numeric($this->id))
		{
			return FALSE;
		}
		
		$this->db->where('id', $this->id);
		$result = $this->db->update('players', $this);		
		
		return $result;
	}
	
	/**
	 * Delete Player
	 * 
	 * This method deletes a player from the database.
	 * 
	 * @access public
	 * @param int $id
	 * @return bool (Returns TRUE if the deletion was successful, or FALSE if the query failed.)
	 */
	public function delete_player($id = NULL)
	{
		// return if no ID, or if ID is not a number.
		if(empty($id) || !is_numeric($id))
		{
			return FALSE;
		}
		
		$this->db->where('id', $id);
		$this->db->delete('players');
		
		if($this->db->affected_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}	
	
}

?>