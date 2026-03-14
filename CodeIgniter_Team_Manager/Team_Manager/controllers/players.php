<?php if( !defined('BASEPATH') ) exit('No direct script access allowed');

/**
 * Players Public Controller
 * 
 * @author Scott Greenhagen
 * @version 1.0
 * @package Team Manager
 */
class Players extends CI_Controller 
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
	 * This method loads the view to display player listing.
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
		$this->load->view('/players/index', $data);
		$this->load->view('footer');
	}
	
	/**
	 * View
	 * 
	 * This method loads the view to display an individual player's details.
	 * 
	 * @access public
	 * @param int $id
	 */
	public function view($id = NULL)
	{
		$this->load->helper('state_helper');
		
		$data['states'] = get_states();		
		$data['player'] = $this->player->get_one_player($id);
		$data['team'] = $this->team->get_one_team($data['player']->team_id);
		
		$this->load->view('header');
		$this->load->view('players/view', $data);
		$this->load->view('footer');
	}
	
}

?>