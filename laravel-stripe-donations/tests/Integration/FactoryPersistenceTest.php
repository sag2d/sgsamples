<?php

use App\Enums\DonationInterval;
use App\Enums\DonationStatus;
use App\Models\Donation;
use App\Models\User;
use Laravel\Cashier\Subscription;

use function Pest\Laravel\assertDatabaseHas;

test('the user factory inserts a verified non-admin user with a hashed password', function () {
    $user = User::factory()->create([
        'name' => 'Factory User',
        'email' => 'factory.user@example.com',
        'password' => 'factory-password',
    ]);

    assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => 'Factory User',
        'email' => 'factory.user@example.com',
        'is_admin' => false,
    ]);

    expect($user->email_verified_at)->not->toBeNull()
        ->and($user->is_admin)->toBeFalse()
        ->and($user->password)->not->toBe('factory-password')
        ->and(password_verify('factory-password', $user->password))->toBeTrue();
});

test('the donation factory inserts a pending donation with a related user', function () {
    $donation = Donation::factory()->create();

    expect($donation->exists)->toBeTrue()
        ->and($donation->user)->toBeInstanceOf(User::class)
        ->and($donation->status)->toBe(DonationStatus::Pending)
        ->and($donation->amount)->toMatch('/^\d+\.\d{2}$/')
        ->and($donation->currency)->toBe('USD')
        ->and($donation->interval)->toBeIn([
            null,
            ...array_map(fn (DonationInterval $interval): string => $interval->value, DonationInterval::cases()),
        ]);

    assertDatabaseHas('donations', [
        'id' => $donation->id,
        'user_id' => $donation->user_id,
        'status' => DonationStatus::Pending->value,
        'currency' => 'USD',
    ]);
});

test('the donation factory can use an existing user without creating another one', function () {
    $user = User::factory()->create();
    $donation = Donation::factory()->for($user)->create([
        'status' => DonationStatus::Completed,
        'interval' => DonationInterval::Month->value,
    ]);

    expect(User::count())->toBe(1)
        ->and($donation->user->is($user))->toBeTrue()
        ->and($donation->status)->toBe(DonationStatus::Completed)
        ->and($donation->interval)->toBe(DonationInterval::Month->value);

    assertDatabaseHas('donations', [
        'id' => $donation->id,
        'user_id' => $user->id,
        'status' => DonationStatus::Completed->value,
        'interval' => DonationInterval::Month->value,
    ]);
});

test('the donation factory persists a subscription relationship when provided', function () {
    $user = User::factory()->create();
    $subscription = Subscription::factory()->for($user)->create();
    $donation = Donation::factory()->for($user)->create([
        'subscription_id' => $subscription->id,
        'status' => DonationStatus::Completed,
        'interval' => DonationInterval::Year->value,
        'stripe_subscription_id' => $subscription->stripe_id,
    ]);

    expect($donation->subscription->is($subscription))->toBeTrue()
        ->and($donation->stripe_subscription_id)->toBe($subscription->stripe_id)
        ->and($donation->status)->toBe(DonationStatus::Completed);

    assertDatabaseHas('donations', [
        'id' => $donation->id,
        'subscription_id' => $subscription->id,
        'stripe_subscription_id' => $subscription->stripe_id,
    ]);
});
