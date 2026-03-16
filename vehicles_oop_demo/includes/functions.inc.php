<?php

/**
 * @author Scott Greenhagen
 * @copyright 2026
 * 
 * Utility functions for Vehicles OOP Demo.
 */

/**
 * vehicle_run()
 *
 * List features and run the provided vehicle's standard functions.
 *
 * @access public
 * @param object $vehicle
 * 
 * @return bool
 */
function vehicle_run($vehicle) {
	// make sure we have a vehicle, and the vehicle is a valid object
	if(empty($vehicle) || !is_object($vehicle)) {
		return false;
	}
	
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
 * vehicle_off()
 *
 * Turn the provided vehicle off.
 *
 * @access public
 * @param object $vehicle
 * 
 * @return bool
 */
function vehicle_off($vehicle) {
	// make sure we have a vehicle, and the vehicle is a valid object
	if(empty($vehicle) || !is_object($vehicle)) {
		return false;
	}
	
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