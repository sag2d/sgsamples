<?php

use App\Enums\DonationStatus;
use App\Models\Donation;
use App\Models\User;
use Laravel\Cashier\Subscription;
use Stripe\ApiRequestor;
use Stripe\HttpClient\ClientInterface;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;

function fakeStripeSubscriptionClient(string $status = 'active'): object
{
    $recorder = new stdClass;
    $recorder->requests = [];

    ApiRequestor::setHttpClient(new class($status, $recorder) implements ClientInterface
    {
        public function __construct(
            private string $status,
            private stdClass $recorder,
        ) {}

        public function request($method, $absUrl, $headers, $params, $hasFile, $apiMode = 'v1', $maxNetworkRetries = null): array
        {
            $this->recorder->requests[] = [
                'method' => strtolower($method),
                'absUrl' => $absUrl,
                'params' => $params,
            ];

            return [
                json_encode([
                    'id' => basename(parse_url($absUrl, PHP_URL_PATH)),
                    'object' => 'subscription',
                    'status' => $this->status,
                    'current_period_end' => now()->addMonth()->timestamp,
                ]),
                200,
                ['content-type: application/json'],
            ];
        }
    });

    return $recorder;
}

test('active recurring donations can be canceled through the controller', function () {
    $requests = fakeStripeSubscriptionClient();
    $user = User::factory()->create();
    $subscription = Subscription::factory()->for($user)->create();
    $donation = Donation::factory()->for($user)->create([
        'subscription_id' => $subscription->id,
        'status' => DonationStatus::Completed,
        'interval' => 'month',
    ]);

    actingAs($user)
        ->post(route('donation-history.cancel', $donation))
        ->assertRedirect(route('donation-history'))
        ->assertSessionHas('status', 'Your recurring donation has been scheduled for cancellation.');

    expect($requests->requests)->toHaveCount(2)
        ->and($requests->requests[0]['method'])->toBe('get')
        ->and($requests->requests[1]['method'])->toBe('post')
        ->and($requests->requests[1]['params']['cancel_at_period_end'])->toBe('true');
});

test('the controller rejects recurring donations whose Stripe subscription is canceled', function () {
    $requests = fakeStripeSubscriptionClient('canceled');
    $user = User::factory()->create();
    $subscription = Subscription::factory()
        ->for($user)
        ->canceled()
        ->create();
    $donation = Donation::factory()->for($user)->create([
        'subscription_id' => $subscription->id,
        'status' => DonationStatus::Completed,
        'interval' => 'month',
    ]);

    actingAs($user)
        ->post(route('donation-history.cancel', $donation))
        ->assertConflict();

    expect($requests->requests)->toHaveCount(1);
});

test('the controller rejects recurring donations with incomplete Stripe payment', function () {
    $requests = fakeStripeSubscriptionClient('incomplete');
    $user = User::factory()->create();
    $subscription = Subscription::factory()
        ->for($user)
        ->incomplete()
        ->create();
    $donation = Donation::factory()->for($user)->create([
        'subscription_id' => $subscription->id,
        'status' => DonationStatus::Completed,
        'interval' => 'month',
    ]);

    actingAs($user)
        ->post(route('donation-history.cancel', $donation))
        ->assertConflict();

    expect($requests->requests)->toHaveCount(1);
});

test('one-time donations can exist without a subscription and remain owned by their user', function () {
    $donation = Donation::factory()->create();

    expect($donation->subscription_id)->toBeNull()
        ->and($donation->status)->toBe(DonationStatus::Pending)
        ->and($donation->user)->toBeInstanceOf(User::class);
});

test('donations persist the Stripe payment method ID column', function () {
    $donation = Donation::factory()->create([
        'stripe_payment_method_id' => 'pm_test_donation',
    ]);

    expect($donation->refresh()->stripe_payment_method_id)->toBe('pm_test_donation');
});

test('seeded recurring donations are linked to completed subscriptions', function () {
    $user = User::where('email', 'demo.user@example.com')->firstOrFail();
    $recurringDonations = $user->donations()
        ->whereNotNull('subscription_id')
        ->with('subscription')
        ->get();

    expect($recurringDonations)->toHaveCount(5);

    $recurringDonations->each(function (Donation $donation) use ($user): void {
        expect($donation->status)->toBe(DonationStatus::Completed)
            ->and($donation->user_id)->toBe($user->id)
            ->and($donation->interval)->not->toBeNull()
            ->and($donation->subscription)->not->toBeNull()
            ->and($donation->subscription->user_id)->toBe($user->id)
            ->and($donation->stripe_subscription_id)->toBe($donation->subscription->stripe_id);
    });
});

test('canceled subscriptions remain linked to their donation and are no longer recurring', function () {
    $user = User::factory()->create();
    $subscription = Subscription::factory()
        ->for($user)
        ->canceled()
        ->create();
    $donation = Donation::factory()->for($user)->create([
        'subscription_id' => $subscription->id,
        'status' => DonationStatus::Completed,
        'interval' => 'month',
        'stripe_subscription_id' => $subscription->stripe_id,
    ]);

    expect($donation->subscription->is($subscription))->toBeTrue()
        ->and($subscription->canceled())->toBeTrue()
        ->and($subscription->ended())->toBeTrue()
        ->and($subscription->recurring())->toBeFalse();
});

test('incomplete subscriptions report incomplete payment and are not active', function () {
    $user = User::factory()->create();
    $subscription = Subscription::factory()
        ->for($user)
        ->incomplete()
        ->create();

    expect($subscription->incomplete())->toBeTrue()
        ->and($subscription->hasIncompletePayment())->toBeTrue()
        ->and($subscription->active())->toBeFalse();
});
test('invalid one-time donation amounts do not create donation records', function () {
    $user = User::factory()->create();
    $donationCount = Donation::count();

    actingAs($user)
        ->get(route('donate-once', ['amount' => 0]))
        ->assertSessionHasErrors('amount');

    assertDatabaseCount('donations', $donationCount);
});

test('invalid recurring intervals do not create donation records', function () {
    $user = User::factory()->create();
    $donationCount = Donation::count();

    actingAs($user)
        ->get(route('donate-recurring', ['amount' => 10, 'interval' => 'decade']))
        ->assertSessionHasErrors('interval');

    assertDatabaseCount('donations', $donationCount);
});

test('donation history only lists the authenticated users donations', function () {
    $user = User::factory()->create();
    $usersDonation = Donation::factory()->for($user)->create([
        'status' => DonationStatus::Completed,
    ]);
    Donation::factory()->for($user)->create([
        'status' => DonationStatus::Pending,
    ]);
    Donation::factory()->create([
        'status' => DonationStatus::Completed,
    ]);

    actingAs($user)
        ->get(route('donation-history'))
        ->assertOk()
        ->assertViewIs('account.donation-history')
        ->assertViewHas('donations', fn ($donations): bool => $donations->count() === 1 && $donations->first()->is($usersDonation)
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
