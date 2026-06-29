<?php

require_once 'class.Vehicle.php';

/**
 * @author Scott Greenhagen
 * @copyright 2026
 * 
 * The AutoShop static class provides utility functions to maintain Vehicle objects.
 */
class AutoShop {

	static $tires_need_air = false;

	/**
	 * AutoShop::check_tires()
	 *
	 * Check tires on the provided vehicle.
	 *
	 * @access public
	 * @param object $vehicle
	 * 
	 * @return bool
	 */
	public static function check_tires($vehicle) {
		// make sure we have a vehicle, and the vehicle is a valid object
		if(empty($vehicle) || !is_object($vehicle)) {
			return false;
		}

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
	 * @param object $vehicle
	 * 
	 * @return bool
	 */
	public static function fill_tires($vehicle) {
		// make sure we have a vehicle, and the vehicle is a valid object
		if(empty($vehicle) || !is_object($vehicle)) {
			return false;
		}

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
	 * @param object $vehicle
	 * 
	 * @return bool
	 */
	public static function change_oil($vehicle) {
		// make sure we have a vehicle, and the vehicle is a valid object
		if(empty($vehicle) || !is_object($vehicle)) {
			return false;
		}

		return true;
	}

}