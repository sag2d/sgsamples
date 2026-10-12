<x-layouts::app :title="__('Donation Receipt')">
    <div class="mx-auto max-w-2xl space-y-8">
        <header class="space-y-2">
            <p class="text-sm font-medium text-green-700 dark:text-green-400">{{ __('Payment successful') }}</p>
            <h1 class="text-2xl font-semibold text-neutral-900 dark:text-neutral-100">{{ __('One-Time Donation Receipt') }}</h1>
            <p class="text-neutral-600 dark:text-neutral-400">{{ __('Thank you for your contribution.') }}</p>
        </header>

        <section class="rounded-lg border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
            <dl class="divide-y divide-neutral-200 dark:divide-neutral-700">
                <div class="flex items-baseline justify-between gap-4 py-4 first:pt-0">
                    <dt class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('Amount paid') }}</dt>
                    <dd class="text-xl font-semibold text-neutral-900 dark:text-neutral-100">
                        ${{ number_format((float) $donation->amount, 2) }} ({{ strtoupper($donation->currency) }})
                    </dd>
                </div>
                <div class="flex items-baseline justify-between gap-4 py-4">
                    <dt class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('Date') }}</dt>
                    <dd class="text-right text-sm text-neutral-900 dark:text-neutral-100">{{ $donation->updated_at->format('M j, Y') }}</dd>
                </div>
                <div class="flex items-baseline justify-between gap-4 py-4">
                    <dt class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('Status') }}</dt>
                    <dd class="text-sm font-medium text-green-700 dark:text-green-400">{{ __('Completed') }}</dd>
                </div>
                @if ($donation->stripe_payment_id || $donation->stripe_payment_intent_id)
                    <div class="flex flex-col gap-1 py-4 last:pb-0">
                        <dt class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('Payment confirmation number') }}</dt>
                        <dd class="break-all font-mono text-xs text-neutral-900 dark:text-neutral-100">
                            {{ $donation->stripe_payment_id ?: $donation->stripe_payment_intent_id }}
                        </dd>
                    </div>
                @endif
            </dl>
        </section>

        <a
            href="{{ route('donation-history') }}"
            class="inline-flex rounded-md border border-neutral-300 px-4 py-2 text-sm font-medium text-neutral-900 hover:bg-neutral-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:border-neutral-700 dark:text-neutral-100 dark:hover:bg-neutral-800"
        >
            {{ __('View donation history') }}
        </a>
    </div>
</x-layouts::app>