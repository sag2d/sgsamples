<?php if( !defined('BASEPATH') ) exit('No direct script access allowed');

/**
 * Leagues Public Controller
 * 
 * @author Scott Greenhagen
 * @version 1.0
 * @package Team Manager
 */
class Leagues extends CI_Controller 
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
	 * This method loads the view to display league listing.
	 * 
	 * @access public	 
	 */
	public function index()
	{
		$data['leagues'] = $this->league->get_leagues();
		
		$this->load->view('header');
		$this->load->view('/leagues/index', $data);
		$this->load->view('footer');
	}
	
	/**
	 * View
	 * 
	 * This method loads the view to display an individual league's details.
	 * 
	 * @access public
	 * @param int $id
	 */
	public function view($id = NULL)
	{
		$data['league'] = $this->league->get_one_league($id);
		
		$this->load->view('header');
		$this->load->view('leagues/view', $data);
		$this->load->view('footer');
	}
	
}

?>