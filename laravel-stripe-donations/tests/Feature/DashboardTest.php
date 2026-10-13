<?php

use App\Enums\DonationStatus;
use App\Models\Donation;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

test('guests are redirected to the login page', function () {
    get(route('dashboard'))->assertRedirect(route('login'));
});

test('authenticated users can visit the dashboard', function () {
    $user = User::factory()->create();

    actingAs($user);

    get(route('dashboard'))->assertOk();
});

test('dashboard summarizes the current users completed usd donations by year', function () {
    $user = User::factory()->create();
    $now = now();
    $startOfThisYear = $now->copy()->startOfYear();

    Donation::factory()->for($user)->create([
        'amount' => 12.50,
        'currency' => 'USD',
        'status' => DonationStatus::Completed,
        'created_at' => $startOfThisYear->copy()->subDay(),
    ]);
    Donation::factory()->for($user)->create([
        'amount' => 5.25,
        'currency' => 'USD',
        'status' => DonationStatus::Completed,
        'created_at' => $startOfThisYear->copy()->addDay(),
    ]);
    Donation::factory()->for($user)->create([
        'amount' => 4.99,
        'currency' => 'USD',
        'status' => DonationStatus::Completed,
        'created_at' => $startOfThisYear->copy()->subYear()->subDay(),
    ]);
    Donation::factory()->for($user)->create([
        'amount' => 99,
        'currency' => 'USD',
        'status' => DonationStatus::Pending,
        'created_at' => $startOfThisYear->copy()->addDay(),
    ]);
    Donation::factory()->create([
        'amount' => 100,
        'currency' => 'USD',
        'status' => DonationStatus::Completed,
        'created_at' => $startOfThisYear->copy()->addDay(),
    ]);

    actingAs($user)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertViewHas('totalDonations', 3)
        ->assertViewHas('lastYearAmount', fn ($amount): bool => (float) $amount === 12.5)
        ->assertViewHas('thisYearAmount', fn ($amount): bool => (float) $amount === 5.25);
});
