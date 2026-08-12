<?php

declare(strict_types=1);

require_once __DIR__ . '/../includes/trait.Timestamp.php';

/**
 * @author Scott Greenhagen
 * @version 1.0
 * @package Vehicles OOP Demo
 *
 * Abstract base class for reporting service status.
 * Uses the Timestamp trait to provide formatted timestamp.
 */
abstract class AbstractStatus {

	// share the trait inside the abstract classes
	use Timestamp;

	/**
	 * AbstractStatus::printStatus()
	 *
	 * Print the time the service ran.
	 *
	 * @access public
	 * @return void
	 */
	public function printStatus(): void {
		echo "Service ran at: " . $this->getFormattedTime() . ".\n";
	}

}
