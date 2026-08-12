<?php

declare(strict_types=1);

require_once 'class.Vehicle.php';

/**
 * @author Scott Greenhagen
 * @version 1.0
 * @package Vehicles OOP Demo
 *
 * Runs standard vehicle operations for the Vehicles OOP Demo.
 */
class VehicleRunner {

	/**
	 * VehicleRunner::run()
	 *
	 * List features and run the provided vehicle's standard functions.
	 *
	 * @access public
	 * @return bool
	 */
	public function run(Vehicle $vehicle): bool {
		// get the vehicle's features
		$vehicle_features = $vehicle->get_features();

		echo "$vehicle->name has the following features...\n";

		foreach($vehicle_features as $key => $value) {
			echo ucfirst($key).": $value \n";
		}

		echo "\n";

		// start the engine
		$started = $vehicle->start_engine();

		if($started) {
			echo "$vehicle->name engine started.\n";
		}

		// check to see if it's running
		if($vehicle->is_running()) {
			echo "$vehicle->name engine is running.\n";
		}

		return true;
	}

	/**
	 * VehicleRunner::off()
	 *
	 * Turn the provided vehicle off.
	 *
	 * @access public
	 * @return bool
	 */
	public function off(Vehicle $vehicle): bool {
		// stop the engine
		$stopped = $vehicle->stop_engine();

		if($stopped) {
			echo "\n$vehicle->name engine stopped.\n";
		}

		// check again to see if it's running
		if(!$vehicle->is_running()) {
			echo "$vehicle->name engine is not running.\n";
		}

		return true;
	}

}
