<?php

declare(strict_types=1);

require_once 'classes/class.Vehicle.php';
require_once 'classes/class.Car.php';
require_once 'classes/class.Motorcycle.php';
require_once 'classes/class.AutoShop.php';
require_once 'classes/class.VehicleRunner.php';

/**
 * @author Scott Greenhagen
 * @version 1.0
 * @package Vehicles OOP Demo
 *
 * This command-line script utilizes the Vehicle class and extending classes as a demonstration of PHP OOP concepts.
 */

echo "Running Vehicles OOP Demo...\n\n";

$runner = new VehicleRunner();
$runner->printStatus();
echo "\n";

// instantiate the Vehicle object as a generic vehicle
$vehicle = new Vehicle('Generic Vehicle');

// run the generic Vehicle's standard functions
$runner->run($vehicle);

// turn the Vehicle off
$runner->off($vehicle);

echo "\n-----\n\n";

// instantiate the Car object as a convertible
$car = new Car('Convertible', true);

// run the Car's standard functions
$runner->run($car);

if($car?->convertible) {
	// lower the convertible's roof
	if($car->roof_lower()) {
		echo "\n$car->name roof lowered.\n";
	}
}

// turn the Car off
$runner->off($car);

echo "\n-----\n\n";

// instantiate the Motorcycle object
$motorcycle = new Motorcycle('Motorcycle');

// run the Motorcycle's standard functions
$runner->run($motorcycle);

// pop a wheelie on the Motorcycle!
if($motorcycle->wheelie()) {
	echo "\n$motorcycle->name popped a wheelie!\n";
}

// turn the Motorcycle off
$runner->off($motorcycle);

// check to see if tires need air on the Motorcycle after wheelie
if(AutoShop::check_tires($motorcycle)) {
	if(AutoShop::fill_tires($motorcycle)) {
		echo "\n$motorcycle->name tires filled with air.\n";
	}

	if(AutoShop::change_oil($motorcycle)) {
		echo "\n$motorcycle->name oil changed.\n";
	}
}

echo "\nDemo ran to completion successfully.\n";
