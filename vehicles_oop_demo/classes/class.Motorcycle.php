<?php

declare(strict_types=1);

require_once 'class.Vehicle.php';

/**
 * @author Scott Greenhagen
 * @copyright 2026
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
