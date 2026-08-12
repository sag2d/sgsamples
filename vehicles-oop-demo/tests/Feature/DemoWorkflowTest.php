<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(VehicleRunner::class)]
#[CoversClass(Car::class)]
#[CoversClass(Motorcycle::class)]
#[CoversClass(AutoShop::class)]
final class DemoWorkflowTest extends TestCase {

	public function testDemoWorkflowRunsAllVehicleScenarios(): void {
		$runner = new VehicleRunner();
		$vehicle = new Vehicle('Generic Vehicle');
		$car = new Car('Convertible', true);
		$motorcycle = new Motorcycle('Motorcycle');

		$this->expectOutputRegex(
			'/Service ran at:.*Generic Vehicle engine started\..*Convertible engine started\..*Convertible roof lowered\..*Motorcycle popped a wheelie!.*Motorcycle tires filled with air\..*Motorcycle oil changed\./s'
		);

		$runner->printStatus();
		echo "\n";

		$runner->run($vehicle);
		$runner->off($vehicle);

		echo "\n-----\n\n";

		$runner->run($car);

		if($car->convertible && $car->roof_lower()) {
			echo "\n$car->name roof lowered.\n";
		}

		$runner->off($car);

		echo "\n-----\n\n";

		$runner->run($motorcycle);

		if($motorcycle->wheelie()) {
			echo "\n$motorcycle->name popped a wheelie!\n";
		}

		$runner->off($motorcycle);

		if(AutoShop::check_tires($motorcycle)) {
			if(AutoShop::fill_tires($motorcycle)) {
				echo "\n$motorcycle->name tires filled with air.\n";
			}

			if(AutoShop::change_oil($motorcycle)) {
				echo "\n$motorcycle->name oil changed.\n";
			}
		}
	}

}
