<?php

namespace Database\Seeders;

use App\Enums\DonationInterval;
use App\Enums\DonationStatus;
use App\Models\Donation;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Laravel\Cashier\Subscription;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // create a demo admin user
        User::factory()->create([
            'name' => 'Demo Admin',
            'email' => 'demo.admin@example.com',
            'password' => bcrypt('demoadmin'),
            'is_admin' => true,
        ]);

        // create a regular demo user
        $demoUser = User::factory()->create([
            'name' => 'Demo User',
            'email' => 'demo.user@example.com',
            'password' => bcrypt('demouser'),
            'is_admin' => false,
        ]);

        // create some one-time donations
        Donation::factory(6)->create([
            'user_id' => $demoUser->id,
            'donor_name' => $demoUser->name,
            'donor_email' => $demoUser->email,
            'status' => DonationStatus::Completed,
            'interval' => null,
            'description' => 'One-time Donation',
        ]);

        // create some recurring donations with subscriptions
        Subscription::factory(5)
            ->state(['user_id' => $demoUser->id])
            ->create()
            ->each(function (Subscription $subscription) use ($demoUser): void {
                $interval = fake()->randomElement(DonationInterval::cases());

                Donation::factory()->create([
                    'user_id' => $demoUser->id,
                    'subscription_id' => $subscription->id,
                    'donor_name' => $demoUser->name,
                    'donor_email' => $demoUser->email,
                    'status' => DonationStatus::Completed,
                    'interval' => $interval->value,
                    'description' => 'Recurring Donation',
                    'stripe_customer_id' => $demoUser->stripe_id,
                    'stripe_subscription_id' => $subscription->stripe_id,
                ]);
            });
    }
}
