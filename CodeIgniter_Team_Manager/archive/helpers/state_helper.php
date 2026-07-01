<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * State Helpers
 * 
 * These helpers pull a list of standard states from the database.
 * State results are primarily for building dropdowns, but could have a variety of uses.
 * 
 * @author Scott Greenhagen
 * @version 1.0
 */


/**
 * Get States
 * 
 * This function gets full state names from the database.
 * 
 * @access public
 * @return mixed (Returns the state data if successful, or FALSE if the query failed.)
 */
if ( ! function_exists('get_states'))
{	
	function get_states()
	{
		$CI =& get_instance();		
		$CI->db->select('id, name');
		$query = $CI->db->get('states');
		
		if($query->num_rows() > 0)
		{
			$states = array('' => 'Please Select One');
			
			foreach($query->result() as $row)
			{
				$states[$row->id] = $row->name;
			}		
			
			return $states;
		}
		else
		{
			return FALSE;
		}		
	}
}

/**
 * Get State Abbreviations
 * 
 * This function gets state abbreviations from the database.
 * 
 * @access public
 * @return mixed (Returns the state data if successful, or FALSE if the query failed.)
 */
if ( ! function_exists('get_state_abbrs'))
{
	function get_state_abbrs()
	{
		$CI =& get_instance();
		$CI->db->select('id, abbr');
		$query = $CI->db->get('states');
		
		if($query->num_rows() > 0)
		{
			$states = array('' => 'Please Select One');
			
			foreach($query->result() as $row)
			{
				$states[$row->id] = $row->abbr;
			}
			
			return $states;
		}
		else
		{
			return FALSE;
		}
	}
}

?>