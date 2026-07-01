<?php if( !defined('BASEPATH') ) exit('No direct script access allowed');

/**
 * Team Admin Controller
 * 
 * @author Scott Greenhagen
 * @version 1.0
 * @package Team Manager
 */
class Team extends CI_Controller 
{
	/**
	 * Constructor
	 * 
	 * @access public	 
	 */	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('team_model', 'team');
		$this->load->model('league_model', 'league');
	}
	
	/**
	 * Index
	 * 
	 * This method loads the view to display the team management listing.
	 * 
	 * @access public	 
	 */
	public function index()
	{		
		$data['teams'] = $this->team->get_teams();
		$leagues = $this->league->get_leagues();
		
		if( !empty($leagues) )
		{
			// build league array
			foreach($leagues as $league)
			{
				$data['leagues'][$league->id] = $league->name;
			}
		}		
		
		$this->load->view('header');
		$this->load->view('/admin/team/index', $data);
		$this->load->view('footer');
	}
	
	/**
	 * Edit
	 * 
	 * This method loads a team record to allow user to add a new team, or edit details for an existing team.
	 * 
	 * @access public	
	 * @param int $id
	 */
	public function edit($id = NULL)
	{		
		$data['team'] = $this->team->get_one_team($id);		
		$data['leagues'] = $this->_build_league_dropdown();
		
		$this->load->view('header');
		$this->load->view('/admin/team/edit', $data);
		$this->load->view('footer');
	}
	
	/**
	 * Build League Dropdown
	 * 
	 * This method builds the array for the league dropdown.
	 * 
	 * @access private
	 * @return array leagues
	 */
	private function _build_league_dropdown()
	{
		$leagues = $this->league->get_leagues();
		
		// build array of leagues for form dropdown
		$data['leagues'][''] = "Please Select One";
		
		if( !empty($leagues) )
		{
			foreach($leagues as $league)
			{
				$data['leagues'][$league->id] = $league->name;
			}
		}		

		return $data['leagues'];
	}
	
	
	/**
	 * Save
	 * 
	 * This method saves a team record.
	 * If the team does not yet exist, a new team is inserted.
	 * If the team does already exists, the existing team is updated.
	 * 
	 * @access public
	 */
	public function save()
	{		
		// set validation rules
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('league_id', 'League', 'required');
			
		$this->load->view('header');
		
		// if validation fails
		if ($this->form_validation->run() == FALSE)
		{		
			$data['leagues'] = $this->_build_league_dropdown();
			
			// repopulate form fields for user to try again
			foreach($_POST as $key => $value)
			{
				$data['team']->$key = $value;
			}
			
			$this->load->view('/admin/team/edit', $data);			
		}
		else
		{		
			$this->team->name = $this->input->post('name');
			$this->team->league_id = $this->input->post('league_id');
			$this->team->mascot = $this->input->post('mascot');
			
			// if existing record, update record
			if($this->input->post('id'))
			{
				$this->team->id = $this->input->post('id');				
				
				$result = $this->team->update_team();
			}
			else
			{				
				// insert new record			
				$result = $this->team->insert_team();
			}		
			
			if($result !== FALSE)
			{
				$this->session->set_flashdata('message', 'Team saved successfully!');				
			}
			else
			{
				$this->session->set_flashdata('error', 'Error saving team. Please try again.');
			}		

			redirect('/admin/team/index');
		}
		
		$this->load->view('footer');
	}
	
	/**
	 * Delete
	 * 
	 * This method deletes a team record from the database.
	 * 
	 * @access public
	 * @param int $id	 
	 */
	public function delete($id = NULL)
	{
		$result = $this->team->delete_team($id);
		
		$this->load->view('header');
		
		if($result !== FALSE)
		{
			$this->session->set_flashdata('message', 'Team deleted successfully.');
		}
		else
		{
			$this->session->set_flashdata('error', 'Error deleting team. Please try again.');
		}
		
		redirect('/admin/team/index');
		
		$this->load->view('footer');
	}
	
}

?>