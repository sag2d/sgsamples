<?php

require_once 'class.Vehicle.php';

/**
 * @author Scott Greenhagen
 * @copyright 2026
 * 
 * The Motorcycle class extends the Vehicle class and defines the different features of a Motorcycle object.
 */
class Motorcycle extends Vehicle {

	public $num_wheels = 2;
	
	protected $windshield = false;
	protected $roof = false;
	
	/**
	 * Motorcycle::wheelie()
	 *
	 * Pop a wheelie!
	 *
	 * @access protected
	 * 
	 * @return bool
	 */
	public function wheelie() {
		return true;
	}

}