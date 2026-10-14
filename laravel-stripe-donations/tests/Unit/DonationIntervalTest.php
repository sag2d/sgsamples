<?php

use App\Enums\DonationInterval;

test('donation intervals expose the expected Stripe values and labels', function (DonationInterval $interval, string $value, string $label) {
    expect($interval->value)->toBe($value)
        ->and($interval->label())->toBe($label);
})->with([
    [DonationInterval::Day, 'day', 'Daily'],
    [DonationInterval::Week, 'week', 'Weekly'],
    [DonationInterval::Month, 'month', 'Monthly'],
    [DonationInterval::Year, 'year', 'Yearly'],
]);
