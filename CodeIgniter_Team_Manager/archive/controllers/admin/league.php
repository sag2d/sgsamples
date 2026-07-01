<?php if( !defined('BASEPATH') ) exit('No direct script access allowed');

/**
 * League Admin Controller
 * 
 * @author Scott Greenhagen
 * @version 1.0
 * @package Team Manager
 */
class League extends CI_Controller 
{
	/**
	 * Constructor
	 * 
	 * @access public	 
	 */	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('league_model', 'league');
	}
	
	/**
	 * Index
	 * 
	 * This method loads the view to display the league management listing.
	 * 
	 * @access public	 
	 */
	public function index()
	{		
		$data['leagues'] = $this->league->get_leagues();
		
		$this->load->view('header');
		$this->load->view('/admin/league/index', $data);
		$this->load->view('footer');
	}
	
	/**
	 * Edit
	 * 
	 * This method loads a league record to allow user to add a new league, or edit details for an existing league.
	 * 
	 * @access public	
	 * @param int $id
	 */
	public function edit($id = NULL)
	{		
		$data['league'] = $this->league->get_one_league($id);		
		
		$this->load->view('header');
		$this->load->view('/admin/league/edit', $data);
		$this->load->view('footer');
	}
	
	/**
	 * Save
	 * 
	 * This method saves a league record.
	 * If the league does not yet exist, a new league is inserted.
	 * If the league does already exists, the existing league is updated.
	 * 
	 * @access public
	 */
	public function save()
	{		
		// set validation rules
		$this->form_validation->set_rules('name', 'Name', 'required');
		
		$this->load->view('header');
		
		// if validation fails
		if ($this->form_validation->run() == FALSE)
		{		
			$this->load->view('/admin/league/edit');			
		}
		else
		{		
			$this->league->name = $this->input->post('name');
			
			// if existing record, update record
			if($this->input->post('id'))
			{
				$this->league->id = $this->input->post('id');				
				
				$result = $this->league->update_league();
			}
			else
			{				
				// insert new record			
				$result = $this->league->insert_league();
			}		
			
			if($result !== FALSE)
			{
				$this->session->set_flashdata('message', 'League saved successfully!');				
			}
			else
			{
				$this->session->set_flashdata('error', 'Error saving league. Please try again.');
			}		

			redirect('/admin/league/index');
		}
		
		$this->load->view('footer');
	}
	
	/**
	 * Delete
	 * 
	 * This method deletes a league record from the database.
	 * 
	 * @access public
	 * @param int $id	 
	 */
	public function delete($id = NULL)
	{
		$result = $this->league->delete_league($id);
		
		$this->load->view('header');
		
		if($result !== FALSE)
		{
			$this->session->set_flashdata('message', 'League deleted successfully.');
		}
		else
		{
			$this->session->set_flashdata('error', 'Error deleting league. Please try again.');
		}
		
		redirect('/admin/league/index');
		
		$this->load->view('footer');
	}
	
}

?>