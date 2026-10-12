<?php

namespace App\Enums;

/**
 * DonationInterval enum to define common Stripe Subscription intervals.
 * 
 * @author Scott Greenhagen
 */
enum DonationInterval: string
{
    case Day = 'day';
    case Week = 'week';
    case Month = 'month';
    case Year = 'year';

    public function label(): string
    {
        return match ($this) {
            self::Day => 'Daily',
            self::Week => 'Weekly',
            self::Month => 'Monthly',
            self::Year => 'Yearly',
        };
    }
}