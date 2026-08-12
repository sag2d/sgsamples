<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(VehicleRunner::class)]
#[CoversClass(Vehicle::class)]
final class VehicleRunnerTest extends TestCase {

	public function testImplementsRunnerInterface(): void {
		$runner = new VehicleRunner();

		$this->assertInstanceOf(Runner::class, $runner);
	}

	public function testRunPrintsFeaturesAndStartsEngine(): void {
		$runner = new VehicleRunner();
		$vehicle = new Vehicle('Sedan');

		$this->expectOutputRegex(
			'/Sedan has the following features\.\.\.\s+Type: Vehicle\s+Wheels: 4\s+.*Sedan engine started\.\s+Sedan engine is running\./s'
		);

		$this->assertTrue($runner->run($vehicle));
		$this->assertTrue($vehicle->is_running());
	}

	public function testOffPrintsStatusAndStopsEngine(): void {
		$runner = new VehicleRunner();
		$vehicle = new Vehicle('Sedan');
		$vehicle->start_engine();

		$this->expectOutputRegex(
			'/Sedan engine stopped\.\s+Sedan engine is not running\./s'
		);

		$this->assertTrue($runner->off($vehicle));
		$this->assertFalse($vehicle->is_running());
	}

}
