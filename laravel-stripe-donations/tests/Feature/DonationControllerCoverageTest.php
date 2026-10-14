<?php

use App\Enums\DonationStatus;
use App\Models\Donation;
use App\Models\User;
use Stripe\ApiRequestor;
use Stripe\HttpClient\ClientInterface;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

function fakeDonationStripeClient(array $responses): object
{
    $recorder = new stdClass;
    $recorder->requests = [];

    ApiRequestor::setHttpClient(new class($responses, $recorder) implements ClientInterface
    {
        public function __construct(
            private array $responses,
            private stdClass $recorder,
        ) {}

        public function request($method, $absUrl, $headers, $params, $hasFile, $apiMode = 'v1', $maxNetworkRetries = null): array
        {
            $path = parse_url($absUrl, PHP_URL_PATH);
            $key = strtolower($method).' '.$path;
            $this->recorder->requests[] = compact('method', 'path', 'params');

            $response = $this->responses[$key] ?? $this->responses['default'];

            return [json_encode($response), 200, ['content-type: application/json']];
        }
    });

    return $recorder;
}

test('one-time donation form creates a pending donation with normalized amount', function () {
    $stripe = fakeDonationStripeClient([
        'post /v1/payment_intents' => [
            'id' => 'pi_test_one_time',
            'object' => 'payment_intent',
            'client_secret' => 'pi_test_one_time_secret',
            'amount' => 1250,
            'currency' => 'usd',
            'customer' => 'cus_test_user',
            'status' => 'requires_payment_method',
        ],
        'default' => [],
    ]);
    $user = User::factory()->create(['stripe_id' => 'cus_test_user']);

    actingAs($user)
        ->get(route('donate-once', ['amount' => '12.5']))
        ->assertOk()
        ->assertViewIs('account.donate-once')
        ->assertViewHas('amount', '12.50')
        ->assertViewHas('clientSecret', 'pi_test_one_time_secret');

    assertDatabaseHas('donations', [
        'user_id' => $user->id,
        'amount' => '12.50',
        'currency' => 'USD',
        'status' => DonationStatus::Pending->value,
        'stripe_payment_intent_id' => 'pi_test_one_time',
    ]);

    expect($stripe->requests[0]['params']['amount'])->toBe(1250)
        ->and($stripe->requests[0]['params']['currency'])->toBe('usd');
});

test('one-time donation completion marks a matching payment as completed', function () {
    $stripe = fakeDonationStripeClient([
        'get /v1/payment_intents/pi_test_complete' => [
            'id' => 'pi_test_complete',
            'object' => 'payment_intent',
            'amount_received' => 2500,
            'currency' => 'usd',
            'customer' => 'cus_test_user',
            'latest_charge' => 'ch_test_charge',
            'payment_method' => 'pm_test_card',
            'status' => 'succeeded',
        ],
        'default' => [],
    ]);
    $user = User::factory()->create(['stripe_id' => 'cus_test_user']);
    $donation = Donation::factory()->for($user)->create([
        'amount' => 25,
        'currency' => 'USD',
        'stripe_customer_id' => 'cus_test_user',
        'stripe_payment_intent_id' => 'pi_test_complete',
        'status' => DonationStatus::Pending,
    ]);

    actingAs($user)
        ->get(route('donate-once.complete', ['payment_intent' => 'pi_test_complete']))
        ->assertOk()
        ->assertViewIs('account.donate-once-complete');

    expect($donation->refresh()->status)->toBe(DonationStatus::Completed)
        ->and($donation->stripe_payment_id)->toBe('ch_test_charge')
        ->and($donation->stripe_payment_method_id)->toBe('pm_test_card');
});

test('active recurring donation completion marks an existing subscription donation as completed', function () {
    $user = User::factory()->create(['stripe_id' => 'cus_test_user']);
    $subscription = \Laravel\Cashier\Subscription::factory()->for($user)->create([
        'stripe_status' => 'active',
    ]);
    $donation = \App\Models\Donation::factory()->for($user)->create([
        'subscription_id' => $subscription->id,
        'stripe_customer_id' => 'cus_test_user',
        'stripe_subscription_id' => $subscription->stripe_id,
        'status' => \App\Enums\DonationStatus::Pending,
        'interval' => 'month',
    ]);
    fakeDonationStripeClient([
        'get /v1/subscriptions/'.$subscription->stripe_id => [
            'id' => $subscription->stripe_id,
            'object' => 'subscription',
            'status' => 'active',
        ],
        'default' => [],
    ]);

    actingAs($user)
        ->get(route('donate-recurring.complete', ['donation_id' => $donation->id]))
        ->assertOk()
        ->assertViewIs('account.donate-recurring-complete');

    expect($donation->refresh()->status)->toBe(\App\Enums\DonationStatus::Completed);
});

test('recurring completion rejects setup intents with mismatched metadata', function () {
    $user = User::factory()->create();
    $donation = \App\Models\Donation::factory()->for($user)->create([
        'status' => \App\Enums\DonationStatus::Pending,
        'interval' => 'week',
    ]);
    fakeDonationStripeClient([
        'get /v1/setup_intents/seti_test_mismatch' => [
            'id' => 'seti_test_mismatch',
            'object' => 'setup_intent',
            'status' => 'succeeded',
            'customer' => 'cus_test_user',
            'payment_method' => 'pm_test_card',
            'metadata' => [
                'donation_id' => (string) ($donation->id + 1),
                'user_id' => (string) $user->id,
            ],
        ],
        'default' => [],
    ]);

    actingAs($user)
        ->get(route('donate-recurring.complete', [
            'donation_id' => $donation->id,
            'setup_intent' => 'seti_test_mismatch',
        ]))
        ->assertForbidden();
});

test('recurring completion rejects setup intents that have not succeeded', function () {
    $user = User::factory()->create();
    $donation = \App\Models\Donation::factory()->for($user)->create([
        'status' => \App\Enums\DonationStatus::Pending,
        'interval' => 'year',
    ]);
    fakeDonationStripeClient([
        'get /v1/setup_intents/seti_test_pending' => [
            'id' => 'seti_test_pending',
            'object' => 'setup_intent',
            'status' => 'requires_payment_method',
            'customer' => null,
            'payment_method' => null,
            'metadata' => [
                'donation_id' => (string) $donation->id,
                'user_id' => (string) $user->id,
            ],
        ],
        'default' => [],
    ]);

    actingAs($user)
        ->get(route('donate-recurring.complete', [
            'donation_id' => $donation->id,
            'setup_intent' => 'seti_test_pending',
        ]))
        ->assertConflict()
        ->assertSee('The payment method setup has not succeeded.');
});
test('recurring donation form creates a pending monthly donation by default', function () {
    $stripe = fakeDonationStripeClient([
        'post /v1/setup_intents' => [
            'id' => 'seti_test_recurring',
            'object' => 'setup_intent',
            'client_secret' => 'seti_test_recurring_secret',
            'customer' => 'cus_test_user',
            'status' => 'requires_payment_method',
        ],
        'default' => [],
    ]);
    $user = User::factory()->create(['stripe_id' => 'cus_test_user']);

    actingAs($user)
        ->get(route('donate-recurring', ['amount' => '18.5']))
        ->assertOk()
        ->assertViewIs('account.donate-recurring')
        ->assertViewHas('amount', '18.50')
        ->assertViewHas('interval', 'month')
        ->assertViewHas('clientSecret', 'seti_test_recurring_secret');

    assertDatabaseHas('donations', [
        'user_id' => $user->id,
        'amount' => '18.50',
        'interval' => 'month',
        'status' => DonationStatus::Pending->value,
        'stripe_customer_id' => 'cus_test_user',
    ]);

    expect($stripe->requests[0]['params']['customer'])->toBe('cus_test_user')
        ->and($stripe->requests[0]['params']['payment_method_types'])->toBe(['card']);
});
