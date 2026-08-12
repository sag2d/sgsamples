<?php

declare(strict_types=1);

require_once __DIR__ . '/../classes/class.Vehicle.php';

/**
 * @author Scott Greenhagen
 * @version 1.0
 * @package Vehicles OOP Demo
 *
 * Defines the contract for running and stopping a vehicle.
 */
interface Runner {

	/**
	 * Runner::run()
	 *
	 * List features and run the provided vehicle's standard functions.
	 *
	 * @access public
	 * @return bool
	 */
	public function run(Vehicle $vehicle): bool;

	/**
	 * Runner::off()
	 *
	 * Turn the provided vehicle off.
	 *
	 * @access public
	 * @return bool
	 */
	public function off(Vehicle $vehicle): bool;

}
