<?php if( !defined('BASEPATH') ) exit('No direct script access allowed');

/**
 * Teams Public Controller
 * 
 * @author Scott Greenhagen
 * @version 1.0
 * @package Team Manager
 */
class Teams extends CI_Controller 
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
	 * This method loads the view to display team listing.
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
		$this->load->view('/teams/index', $data);
		$this->load->view('footer');
	}
	
	/**
	 * View
	 * 
	 * This method loads the view to display an individual team's details.
	 * 
	 * @access public
	 * @param int $id
	 */
	public function view($id = NULL)
	{
		$data['team'] = $this->team->get_one_team($id);
		$data['league'] = $this->league->get_one_league($data['team']->league_id);
		
		$this->load->view('header');
		$this->load->view('teams/view', $data);
		$this->load->view('footer');
	}
	
}

?>