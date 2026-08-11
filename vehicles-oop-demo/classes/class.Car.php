<?php

declare(strict_types=1);

require_once 'class.Vehicle.php';

/**
 * The RoofPosition enum defines valid convertible roof positions for Car objects.
 */
enum RoofPosition: string {
	case Up = 'up';
	case Down = 'down';
}

/**
 * @author Scott Greenhagen
 * @version 1.0
 * @package Vehicles OOP Demo
 * 
 * The Car class extends the Vehicle class and defines the extra features of a Car object.
 */
class Car extends Vehicle {
	
	public bool $convertible = false {
		set => $value;
	}
	
	protected RoofPosition $roof_position = RoofPosition::Up {
		set => $value;
	}
	
	/**
	 * Car::__construct()
	 *
	 * Extended constructor for Car class to check for convertible.
	 *
	 * @access public
	 * @param string $name
	 * @param bool $convertible
	 */
	public function __construct(string $name, bool $convertible=false) {
		// call the parent constructor
		parent::__construct($name);
		
		$this->convertible = $convertible;
	}

	/**
	 * Car::roof_lower()
	 *
	 * Lower the roof of the car if it's a convertible.
	 *
	 * @access public
	 * 
	 * @return bool
	 */
	public function roof_lower(): bool {
		// make sure this car is a convertible before attempting to modify the roof!
		if(!$this->convertible) {
			return false;
		}
		
		// lower the convertible's roof
		$this->roof_position = RoofPosition::Down;
		
		return true;
	}
	
	/**
	 * Car::roof_raise()
	 *
	 * Raise the roof of the car if it's a convertible.
	 *
	 * @access public
	 * 
	 * @return bool
	 */
	public function roof_raise(): bool {
		// make sure this car is a convertible before attempting to modify the roof!
		if(!$this->convertible) {
			return false;
		}
		
		// raise the roof!
		$this->roof_position = RoofPosition::Up;
		
		return true;
	}
	
}
