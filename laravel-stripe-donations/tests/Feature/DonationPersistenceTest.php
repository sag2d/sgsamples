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

test('donation history only lists the authenticated users donations', function () {
    $user = User::factory()->create();
    $usersDonation = Donation::factory()->for($user)->create();
    Donation::factory()->create();

    actingAs($user)
        ->get(route('donation-history'))
        ->assertOk()
        ->assertViewIs('account.donation-history')
        ->assertViewHas('donations', fn ($donations): bool =>
            $donations->count() === 1 && $donations->first()->is($usersDonation)
        );
});

test('users cannot cancel another users donation', function () {
    $user = User::factory()->create();
    $donation = Donation::factory()->create();

    actingAs($user)
        ->post(route('donation-history.cancel', $donation))
        ->assertNotFound();
});

test('one-time donations cannot be canceled as subscriptions', function () {
    $donation = Donation::factory()->create();

    actingAs($donation->user)
        ->post(route('donation-history.cancel', $donation))
        ->assertNotFound();
});
