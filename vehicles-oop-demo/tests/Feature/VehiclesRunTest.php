<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Vehicle::class)]
#[CoversClass(Car::class)]
#[CoversClass(Motorcycle::class)]
#[CoversClass(AutoShop::class)]
#[CoversClass(VehicleRunner::class)]
#[CoversClass(AbstractStatus::class)]
final class VehiclesRunTest extends TestCase {

	public function testVehiclesRunScriptCompletesSuccessfully(): void {
		$command = escapeshellarg(PHP_BINARY) . ' ' . escapeshellarg(PROJECT_ROOT . '/vehicles_run.php');
		$output = shell_exec($command);

		$this->assertNotFalse($output);
		$this->assertStringContainsString('Running Vehicles OOP Demo...', $output);
		$this->assertStringContainsString('Service ran at:', $output);
		$this->assertStringContainsString('Generic Vehicle engine started.', $output);
		$this->assertStringContainsString('Convertible roof lowered.', $output);
		$this->assertStringContainsString('Motorcycle popped a wheelie!', $output);
		$this->assertStringContainsString('Motorcycle tires filled with air.', $output);
		$this->assertStringContainsString('Motorcycle oil changed.', $output);
		$this->assertStringContainsString('Demo ran to completion successfully.', $output);
	}

}
