<?php if( !defined('BASEPATH') ) exit('No direct script access allowed');

/**
 * Team Model
 * 
 * @author Scott Greenhagen
 * @version 1.0
 * @package Team Manager
 */
class Team_model extends CI_Model
{
	var $id;
	var $league_id;
	var $name;
	var $mascot;
	
	/**
	 * Insert Team
	 * 
	 * This method inserts a new team into the database.	
	 * 
	 * @access public
	 * @return mixed (Returns the record ID if the insert was successful, or FALSE if it failed.)
	 */
	public function insert_team()
	{		
		$this->db->insert('teams', $this);
		
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
	 * Get One Team
	 * 
	 * This method gets a single team from the database, specified by ID.
	 * 
	 * @access public
	 * @param int $id
	 * @return mixed (Returns the team data if successful, or FALSE if the query failed.)
	 */
	public function get_one_team($id = NULL)
	{
		// return if no ID, or if ID is not a number.
		if(empty($id) || !is_numeric($id))
		{
			return FALSE;
		}
		
		$this->db->where('id', $id);
		$query = $this->db->get('teams');
		
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
	 * Get Teams
	 * 
	 * This method gets teams from the database.
	 * 
	 * @access public
	 * @return mixed (Returns the team data if successful, or FALSE if the query failed.)
	 */
	public function get_teams()
	{
		$this->db->order_by('league_id', 'ASC');
		$query = $this->db->get('teams');
		
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
	 * Update Team
	 * 
	 * This method updates a team in the database.
	 * 
	 * @access public
	 * @return bool (Returns TRUE if the update was successful, or FALSE if the query failed.)
	 */
	public function update_team()
	{	
		// return if no ID, or if ID is not a number.
		if(empty($this->id) || !is_numeric($this->id))
		{
			return FALSE;
		}
		
		$this->db->where('id', $this->id);
		$result = $this->db->update('teams', $this);		
		
		return $result;
	}
	
	/**
	 * Delete Team
	 * 
	 * This method deletes a team from the database.
	 * 
	 * @access public
	 * @param int $id
	 * @return bool (Returns TRUE if the deletion was successful, or FALSE if the query failed.)
	 */
	public function delete_team($id = NULL)
	{
		// return if no ID, or if ID is not a number.
		if(empty($id) || !is_numeric($id))
		{
			return FALSE;
		}
		
		$this->db->where('id', $id);
		$this->db->delete('teams');
		
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