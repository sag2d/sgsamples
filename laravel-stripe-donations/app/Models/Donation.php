<?php

namespace App\Models;

use App\Enums\DonationStatus;
use Database\Factories\DonationFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Cashier\Subscription;

#[Fillable(['user_id', 'subscription_id', 'donor_name', 'donor_email', 'amount', 'currency', 'status', 'interval', 'description', 'stripe_payment_id', 'stripe_payment_method_id', 'stripe_customer_id', 'stripe_payment_intent_id', 'stripe_subscription_id'])]
#[Hidden([])]
class Donation extends Model
{
    /** @use HasFactory<DonationFactory> */
    use HasFactory;

    /**
     * Get the user who made the donation.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the Cashier subscription associated with the donation, if any.
     */
    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    /**
     * Cast monetary amounts to a fixed two-decimal representation.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'status' => DonationStatus::class,
        ];
    }
}
