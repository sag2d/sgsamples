<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AbstractStatus::class)]
final class AbstractStatusTest extends TestCase {

	public function testGetFormattedTimeMatchesExpectedPattern(): void {
		$status = new class extends AbstractStatus {};

		$this->assertMatchesRegularExpression(
			'/^[A-Za-z]+ \d{1,2}, \d{4}, \d{1,2}:\d{2} (am|pm)$/',
			$status->getFormattedTime()
		);
	}

	public function testPrintStatusOutputsTimestamp(): void {
		$status = new class extends AbstractStatus {};

		$this->expectOutputRegex('/Service ran at: [A-Za-z]+ \d{1,2}, \d{4}, \d{1,2}:\d{2} (am|pm)\./');

		$status->printStatus();
	}

}
