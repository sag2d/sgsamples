<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AbstractStatus::class)]
final class AbstractStatusTest extends TestCase {

	public function testGetFormattedTimeMatchesExpectedPattern(): void {
		$status = new class extends AbstractStatus {};

		$this->assertMatchesRegularExpression(
			'/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/',
			$status->getFormattedTime()
		);
	}

	public function testPrintStatusOutputsTimestamp(): void {
		$status = new class extends AbstractStatus {};

		$this->expectOutputRegex('/Service ran at: \d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\./');

		$status->printStatus();
	}

}
