<?php

namespace App\Enums;

/**
 * DonationStatus enum to define the status of a donation.
 * 
 * @author Scott Greenhagen
 */
enum DonationStatus: string
{
    case Pending = 'pending';
    case Completed = 'completed';
}
