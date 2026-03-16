<?php

require_once 'class.Vehicle.php';

/**
 * @author Scott Greenhagen
 * @copyright 2026
 * 
 * The Car class extends the Vehicle class and defines the extra features of a Car object.
 */
class Car extends Vehicle {
	
	public $convertible = false;
	
	protected $roof_position = 'up';
	
	/**
	 * Car::__construct()
	 *
	 * Extended constructor for Car class to check for convertible.
	 *
	 * @access public
	 * @param string $name
	 * @param bool $convertible
	 */
	public function __construct($name, $convertible=false) {
		// call the parent constructor
		parent::__construct($name);
		
		// if convertible was specified
		if(!empty($convertible)) {
			$this->convertible = $convertible;
		}
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
	public function roof_lower() {
		// make sure this car is a convertible before attempting to modify the roof!
		if(!$this->convertible) {
			return false;
		}
		
		// lower the convertible's roof
		$this->roof_position = 'down';
		
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
	public function roof_raise() {
		// make sure this car is a convertible before attempting to modify the roof!
		if(!$this->convertible) {
			return false;
		}
		
		// raise the roof!
		$this->roof_position = 'up';
		
		return true;
	}
	
}