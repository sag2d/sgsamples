<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Motorcycle::class)]
final class MotorcycleTest extends TestCase {

	public function testGetFeaturesReflectMotorcycleDefaults(): void {
		$motorcycle = new Motorcycle('Bike');

		$this->assertSame([
			'type' => Motorcycle::class,
			'wheels' => 2,
			'windshield' => 'No',
			'roof' => 'No',
			'running' => 'No',
		], $motorcycle->get_features());
	}

	public function testStartEngineStartsSuccessfully(): void {
		$motorcycle = new Motorcycle('Bike');

		$this->assertTrue($motorcycle->start_engine());
		$this->assertTrue($motorcycle->is_running());
	}

	public function testWheelieReturnsTrue(): void {
		$motorcycle = new Motorcycle('Bike');

		$this->assertTrue($motorcycle->wheelie());
	}

	public function testNegativeWheelCountThrowsException(): void {
		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage('A motorcycle cannot have a negative number of wheels.');

		$motorcycle = new Motorcycle('Invalid');
		$motorcycle->num_wheels = -1;
	}

	public function testStartEngineThrowsWhenRoofIsPresent(): void {
		$motorcycle = new Motorcycle('Invalid Bike');
		$roof = new ReflectionProperty(Motorcycle::class, 'roof');
		$roof->setValue($motorcycle, true);

		$this->expectException(RuntimeException::class);
		$this->expectExceptionMessage('A motorcycle cannot have a roof.');

		$motorcycle->start_engine();
	}

}
