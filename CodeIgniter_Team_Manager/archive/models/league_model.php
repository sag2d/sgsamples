<?php if( !defined('BASEPATH') ) exit('No direct script access allowed');

/**
 * League Model
 * 
 * @author Scott Greenhagen
 * @version 1.0
 * @package Team Manager
 */
class League_model extends CI_Model
{
	var $id;
	var $name;
	
	/**
	 * Insert League
	 * 
	 * This method inserts a new league into the database.	
	 * 
	 * @access public
	 * @return mixed (Returns the record ID if the insert was successful, or FALSE if it failed.)
	 */
	public function insert_league()
	{		
		$this->db->insert('leagues', $this);
		
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
	 * Get One League
	 * 
	 * This method gets a single league from the database, specified by ID.
	 * 
	 * @access public
	 * @param int $id
	 * @return mixed (Returns the league data if successful, or FALSE if the query failed.)
	 */
	public function get_one_league($id = NULL)
	{
		// return if no ID, or if ID is not a number.
		if(empty($id) || !is_numeric($id))
		{
			return FALSE;
		}
		
		$this->db->where('id', $id);
		$query = $this->db->get('leagues');
		
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
	 * Get Leagues
	 * 
	 * This method gets leagues from the database.
	 * 
	 * @access public
	 * @return mixed (Returns the league data if successful, or FALSE if the query failed.)
	 */
	public function get_leagues()
	{
		$query = $this->db->get('leagues');
		
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
	 * Update League
	 * 
	 * This method updates a league in the database.
	 * 
	 * @access public
	 * @return bool (Returns TRUE if the update was successful, or FALSE if the query failed.)
	 */
	public function update_league()
	{	
		// return if no ID, or if ID is not a number.
		if(empty($this->id) || !is_numeric($this->id))
		{
			return FALSE;
		}
		
		$this->db->where('id', $this->id);		
		$result = $this->db->update('leagues', $this);
		
		return $result;
	}
	
	/**
	 * Delete League
	 * 
	 * This method deletes a league from the database.
	 * 
	 * @access public
	 * @param int $id
	 * @return bool (Returns TRUE if the deletion was successful, or FALSE if the query failed.)
	 */
	public function delete_league($id = NULL)
	{
		// return if no ID, or if ID is not a number.
		if(empty($id) || !is_numeric($id))
		{
			return FALSE;
		}
		
		$this->db->where('id', $id);
		$this->db->delete('leagues');
		
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