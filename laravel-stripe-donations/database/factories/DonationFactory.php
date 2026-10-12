<?php

namespace Database\Factories;

use App\Enums\DonationInterval;
use App\Enums\DonationStatus;
use App\Models\Donation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Donation>
 */
class DonationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'subscription_id' => null,
            'donor_name' => fake()->name(),
            'donor_email' => fake()->safeEmail(),
            'amount' => fake()->randomFloat(2, 1, 10000),
            'currency' => 'USD',
            'status' => DonationStatus::Pending,
            'interval' => fake()->randomElement([
                null,
                ...array_map(
                    fn (DonationInterval $interval): string => $interval->value,
                    DonationInterval::cases(),
                ),
            ]),
            'description' => fake()->sentence(),
            'stripe_payment_id' => null,
            'stripe_payment_method' => null,
            'stripe_customer_id' => null,
            'stripe_payment_intent_id' => null,
            'stripe_subscription_id' => null,
        ];
    }
}
