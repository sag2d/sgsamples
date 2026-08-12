<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Car::class)]
#[CoversClass(RoofPosition::class)]
final class CarTest extends TestCase {

	public function testConstructorSetsConvertibleFlag(): void {
		$car = new Car('Convertible', true);

		$this->assertSame('Convertible', $car->name);
		$this->assertTrue($car->convertible);
	}

	public function testRoofLowerReturnsTrueForConvertible(): void {
		$car = new Car('Convertible', true);

		$this->assertTrue($car->roof_lower());
	}

	public function testRoofLowerReturnsFalseForNonConvertible(): void {
		$car = new Car('Sedan');

		$this->assertFalse($car->roof_lower());
	}

	public function testRoofRaiseReturnsTrueForConvertible(): void {
		$car = new Car('Convertible', true);
		$car->roof_lower();

		$this->assertTrue($car->roof_raise());
	}

	public function testRoofRaiseReturnsFalseForNonConvertible(): void {
		$car = new Car('Sedan');

		$this->assertFalse($car->roof_raise());
	}

	public function testRoofPositionEnumValues(): void {
		$this->assertSame('up', RoofPosition::Up->value);
		$this->assertSame('down', RoofPosition::Down->value);
	}

}
