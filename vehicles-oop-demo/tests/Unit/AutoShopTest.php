<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AutoShop::class)]
final class AutoShopTest extends TestCase {

	public function testCheckTiresReturnsTrue(): void {
		$vehicle = new Vehicle('Sedan');

		$this->assertTrue(AutoShop::check_tires($vehicle));
	}

	public function testFillTiresReturnsTrue(): void {
		$vehicle = new Vehicle('Sedan');
		AutoShop::check_tires($vehicle);

		$this->assertTrue(AutoShop::fill_tires($vehicle));
	}

	public function testChangeOilReturnsTrue(): void {
		$vehicle = new Vehicle('Sedan');

		$this->assertTrue(AutoShop::change_oil($vehicle));
	}

}
