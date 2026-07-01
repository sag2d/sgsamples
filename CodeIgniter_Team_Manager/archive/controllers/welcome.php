<?php if( !defined('BASEPATH') ) exit('No direct script access allowed');

/**
 * Welcome Controller
 * 
 * @author Scott Greenhagen
 * @version 1.0
 * @package Team Manager
 */
class Welcome extends CI_Controller 
{

	/**
	 * Index method simply loads the views to display a welcome page to the user.	 
	 */
	public function index()
	{
		$this->load->view('welcome_header');
		$this->load->view('welcome_message');
		$this->load->view('footer');
	}
	
}

?>