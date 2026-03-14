<?php if( !defined('BASEPATH') ) exit('No direct script access allowed');

/**
 * Player Admin Controller
 * 
 * @author Scott Greenhagen
 * @version 1.0
 * @package Team Manager
 */
class Player extends CI_Controller 
{
	/**
	 * Constructor
	 * 
	 * @access public	 
	 */	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('player_model', 'player');
		$this->load->model('team_model', 'team');		
	}
	
	/**
	 * Index
	 * 
	 * This method loads the view to display the player management listing.
	 * 
	 * @access public	 
	 */
	public function index()
	{		
		$data['players'] = $this->player->get_players();
		$teams = $this->team->get_teams();
		
		if( !empty($teams) )
		{
			// build team array
			foreach($teams as $team)
			{
				$data['teams'][$team->id] = $team->name;
			}
		}		
		
		$this->load->view('header');
		$this->load->view('/admin/player/index', $data);
		$this->load->view('footer');
	}
	
	/**
	 * Edit
	 * 
	 * This method loads a player record to allow user to add a new player, or edit details for an existing player.
	 * 
	 * @access public	
	 * @param int $id
	 */
	public function edit($id = NULL)
	{		
		$this->load->helper('state_helper');
		
		$data['states'] = get_states();		
		$data['player'] = $this->player->get_one_player($id);		
		$data['teams'] = $this->_build_team_dropdown();	
		
		$this->load->view('header');
		$this->load->view('/admin/player/edit', $data);
		$this->load->view('footer');
	}
	
	/**
	 * Build Team Dropdown
	 * 
	 * This method builds the array for the team dropdown.
	 * 
	 * @access private
	 * @return array teams
	 */
	private function _build_team_dropdown()
	{
		$teams = $this->team->get_teams();		
		
		// build array of teams for form dropdown
		$data['teams'][''] = "Please Select One";
		
		if( !empty($teams) )
		{
			foreach($teams as $team)
			{
				$data['teams'][$team->id] = $team->name;
			}
		}		

		return $data['teams'];
	}
	
	
	/**
	 * Save
	 * 
	 * This method saves a player record.
	 * If the player does not yet exist, a new player is inserted.
	 * If the player does already exists, the existing player is updated.
	 * 
	 * @access public
	 */
	public function save()
	{		
		// set validation rules
		$this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
		$this->form_validation->set_rules('team_id', 'Team', 'required');
		$this->form_validation->set_rules('email', 'Email', 'valid_email');
			
		$this->load->view('header');
		
		// if validation fails
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->helper('state_helper');
		
			$data['states'] = get_states();				
			$data['teams'] = $this->_build_team_dropdown();
			
			// repopulate form fields for user to try again
			foreach($_POST as $key => $value)
			{
				$data['player']->$key = $value;
			}
			
			$this->load->view('/admin/player/edit', $data);			
		}
		else
		{		
			$this->player->first_name = $this->input->post('first_name');
			$this->player->last_name = $this->input->post('last_name');
			$this->player->team_id = $this->input->post('team_id');
			$this->player->address = $this->input->post('address');
			$this->player->city = $this->input->post('city');
			$this->player->state_id = $this->input->post('state_id');
			$this->player->zip = $this->input->post('zip');
			$this->player->email = $this->input->post('email');
			$this->player->phone = $this->input->post('phone');
			
			// if existing record, update record
			if($this->input->post('id'))
			{
				$this->player->id = $this->input->post('id');				
				
				$result = $this->player->update_player();
			}
			else
			{				
				// insert new record			
				$result = $this->player->insert_player();
			}		
			
			if($result !== FALSE)
			{
				$this->session->set_flashdata('message', 'Player saved successfully!');				
			}
			else
			{
				$this->session->set_flashdata('error', 'Error saving player. Please try again.');
			}		

			redirect('/admin/player/index');
		}
		
		$this->load->view('footer');
	}
	
	/**
	 * Delete
	 * 
	 * This method deletes a player record from the database.
	 * 
	 * @access public
	 * @param int $id	 
	 */
	public function delete($id = NULL)
	{
		$result = $this->player->delete_player($id);
		
		$this->load->view('header');
		
		if($result !== FALSE)
		{
			$this->session->set_flashdata('message', 'Player deleted successfully.');
		}
		else
		{
			$this->session->set_flashdata('error', 'Error deleting player. Please try again.');
		}
		
		redirect('/admin/player/index');
		
		$this->load->view('footer');
	}
	
}

?>