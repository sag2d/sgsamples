<?php

use App\Enums\DonationStatus;
use App\Models\Donation;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;

test('one-time donations can exist without a subscription and remain owned by their user', function () {
    $donation = Donation::factory()->create();

    expect($donation->subscription_id)->toBeNull()
        ->and($donation->status)->toBe(DonationStatus::Pending)
        ->and($donation->user)->toBeInstanceOf(User::class);
});

test('invalid one-time donation amounts do not create donation records', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->get(route('donate-once', ['amount' => 0]))
        ->assertSessionHasErrors('amount');

    assertDatabaseCount('donations', 0);
});

test('invalid recurring intervals do not create donation records', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->get(route('donate-recurring', ['amount' => 10, 'interval' => 'decade']))
        ->assertSessionHasErrors('interval');

    assertDatabaseCount('donations', 0);
});
