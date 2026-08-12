<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Vehicle::class)]
final class VehicleTest extends TestCase {

	public function testConstructorSetsTrimmedName(): void {
		$vehicle = new Vehicle('  Sedan  ');

		$this->assertSame('Sedan', $vehicle->name);
	}

	public function testGetFeaturesReturnsExpectedValues(): void {
		$vehicle = new Vehicle('Sedan');

		$this->assertSame([
			'type' => Vehicle::class,
			'wheels' => 4,
			'windshield' => 'Yes',
			'roof' => 'Yes',
			'running' => 'No',
		], $vehicle->get_features());
	}

	public function testEngineLifecycle(): void {
		$vehicle = new Vehicle('Sedan');

		$this->assertFalse($vehicle->is_running());
		$this->assertTrue($vehicle->start_engine());
		$this->assertTrue($vehicle->is_running());
		$this->assertTrue($vehicle->stop_engine());
		$this->assertFalse($vehicle->is_running());
	}

	public function testNegativeWheelCountThrowsException(): void {
		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage('A vehicle cannot have a negative number of wheels.');

		$vehicle = new Vehicle('Invalid');
		$vehicle->num_wheels = -1;
	}

	public function testDestructorStopsEngine(): void {
		$vehicle = new Vehicle('Sedan');
		$vehicle->start_engine();

		unset($vehicle);

		$this->assertTrue(true);
	}

}
