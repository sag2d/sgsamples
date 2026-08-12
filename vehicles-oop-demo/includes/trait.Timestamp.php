<?php

declare(strict_types=1);

/**
 * @author Scott Greenhagen
 * @version 1.0
 * @package Vehicles OOP Demo
 *
 * Provides formatted timestamp functionality as a trait.
 */
trait Timestamp {

	/**
	 * Timestamp::getFormattedTime()
	 *
	 * Get the current date and time as a formatted string.
	 *
	 * @access public
	 * @return string
	 */
	public function getFormattedTime(): string {
		return date('Y-m-d H:i:s');
	}

}
