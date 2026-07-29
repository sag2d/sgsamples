<?php

declare(strict_types=1);

/**
 * @author Scott Greenhagen
 * @copyright 2026
 * 
 * The base parent Vehicle class defines the common features of most vehicles in this project.
 */
class Vehicle {
	
	public string $name = '' {
		set => trim($value);
	}

	public int $num_wheels = 4 {
		set {
			if($value < 0) {
				throw new InvalidArgumentException('A vehicle cannot have a negative number of wheels.');
			}

			$this->num_wheels = $value;
		}
	}
	
	protected bool $windshield = true {
		set => $value;
	}

	protected bool $roof = true {
		set => $value;
	}
	
	private bool $engine_running = false {
		set => $value;
	}
	
	/**
	 * Vehicle::__construct()
	 *
	 * Constructor for Vehicle class.
	 *
	 * @access public
	 * @param string $name
	 */
	public function __construct(string $name) {
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
	public function get_features(): array {
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
	public function start_engine(): bool {
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
	public function is_running(): bool {
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
	public function stop_engine(): bool {
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
