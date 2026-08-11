<?php

declare(strict_types=1);

require_once 'class.Vehicle.php';

/**
 * @author Scott Greenhagen
 * @version 1.0
 * @package Vehicles OOP Demo
 * 
 * The AutoShop static class provides utility functions to maintain Vehicle objects.
 */
class AutoShop {

	protected static bool $tires_need_air = false;

	/**
	 * AutoShop::check_tires()
	 *
	 * Check tires on the provided vehicle.
	 *
	 * @access public
	 * @return bool
	 */
	public static function check_tires(Vehicle $vehicle): bool {
		// example of static reference with "self" that cannot be modified in extended function
		self::$tires_need_air = true;

		return self::$tires_need_air;
	}

	/**
	 * AutoShop::fill_tires()
	 *
	 * Fill tires with air on the provided vehicle.
	 *
	 * @access public
	 * @return bool
	 */
	public static function fill_tires(Vehicle $vehicle): bool {
		// example of late static binding with "static" that can be modified in extended function
		static::check_tires($vehicle);

		if(static::$tires_need_air) {
			// tires filled
			static::$tires_need_air = false;
		}

		return true;
	}

	/**
	 * AutoShop::change_oil()
	 *
	 * Change the oil on the provided vehicle.
	 *
	 * @access public
	 * @return bool
	 */
	public static function change_oil(Vehicle $vehicle): bool {
		return true;
	}

}
