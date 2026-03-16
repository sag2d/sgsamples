<?php

/**
 * @author Scott Greenhagen
 * @copyright 2026
 * 
 * The base parent Vehicle class defines the common features of most vehicles in this project.
 */
class Vehicle {
	
	public $name = '';
	public $num_wheels = 4;
	
	protected $windshield = true;
	protected $roof = true;
	
	private $engine_running = false;
	
	/**
	 * Vehicle::__construct()
	 *
	 * Constructor for Vehicle class.
	 *
	 * @access public
	 * @param string $name
	 */
	public function __construct($name) {
		// set the name of the current vehicle
		$this->name = $name;
	}
	
	/**
	 * Vehicle::get_features()
	 *
	 * Get list of features for the current vehicle.
	 *
	 * @access public
	 * 
	 * @return array $features
	 */
	public function get_features() {
		// set the features of the current vehicle in a human-readable format
		$features = [
			'type' => get_class($this),
			'wheels' => $this->num_wheels,
			'windshield' => ($this->windshield === true) ? 'Yes' : 'No',
			'roof' => ($this->roof === true) ? 'Yes' : 'No',
			'running' => ($this->engine_running === true) ? 'Yes' : 'No'
		];
		
		return $features;
	}
	
	/**
	 * Vehicle::start_engine()
	 *
	 * Start the current vehicle's engine.
	 *
	 * @access public
	 * 
	 * @return bool $success
	 */
	public function start_engine() {
		$this->engine_running = true;
		
		return true;
	}
	
	/**
	 * Vehicle::is_running()
	 *
	 * Return the status of the current vehicle's engine to see if it is running.
	 *
	 * @access public
	 * 
	 * @return bool $engine_running
	 */
	public function is_running() {
		return $this->engine_running;
	}
	
	/**
	 * Vehicle::stop_engine()
	 *
	 * Stop the current vehicle's engine.
	 *
	 * @access public
	 * 
	 * @return bool $success
	 */
	public function stop_engine() {
		$this->engine_running = false;
		
		return true;
	}
	
	/**
	 * Vehicle::__destruct()
	 *
	 * Destructor for Vehicle class.
	 *
	 * @access public
	 */
	public function __destruct() {
		// make sure the current vehicle's engine is stopped
		$this->stop_engine();
	}
}