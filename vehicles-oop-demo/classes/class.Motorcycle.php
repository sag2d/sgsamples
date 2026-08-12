<?php

declare(strict_types=1);

require_once 'class.Vehicle.php';

/**
 * @author Scott Greenhagen
 * @version 1.0
 * @package Vehicles OOP Demo
 * 
 * The Motorcycle class extends the Vehicle class and defines the different features of a Motorcycle object.
 */
class Motorcycle extends Vehicle {

	public int $num_wheels = 2 {
		set {
			if($value < 0) {
				throw new InvalidArgumentException('A motorcycle cannot have a negative number of wheels.');
			}

			$this->num_wheels = $value;
		}
	}
	
	protected bool $windshield = false {
		set => $value;
	}

	protected bool $roof = false {
		set => $value;
	}

	/**
	 * Motorcycle::start_engine()
	 *
	 * Extended, overriding start engine method to check for no roof.
	 *
	 * @access public
	 * 
	 * @return bool $success
	 */
	public function start_engine(): bool {
		// extra check to make sure the motorcycle has no roof
		if($this->roof) {
			throw new RuntimeException('A motorcycle cannot have a roof.');
		}

		// call the parent method and return
		return parent::start_engine();
	}
	
	/**
	 * Motorcycle::wheelie()
	 *
	 * Pop a wheelie!
	 *
	 * @access public
	 * 
	 * @return bool
	 */
	public function wheelie(): bool {
		return true;
	}

}
