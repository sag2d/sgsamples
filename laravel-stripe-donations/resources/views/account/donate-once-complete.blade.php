<x-layouts::app :title="__('Donation Receipt')">
    <div class="mx-auto max-w-2xl space-y-8">
        <header class="space-y-2">
            <p class="text-sm font-semibold text-[#557a5e]">{{ __('Payment successful') }}</p>
            <h1 class="text-3xl font-semibold text-[#173f2b]">{{ __('One-Time Donation Receipt') }}</h1>
            <p class="text-[#536b59]">{{ __('Thank you for your contribution.') }}</p>
        </header>

        <section class="rounded-lg border border-[#d6e4d5] bg-[#f8fbf7] p-6">
            <dl class="divide-y divide-[#d6e4d5]">
                <div class="flex items-baseline justify-between gap-4 py-4 first:pt-0">
                    <dt class="text-sm text-[#536b59]">{{ __('Amount paid') }}</dt>
                    <dd class="text-xl font-semibold text-[#173f2b]">
                        ${{ number_format((float) $donation->amount, 2) }} ({{ strtoupper($donation->currency) }})
                    </dd>
                </div>
                <div class="flex items-baseline justify-between gap-4 py-4">
                    <dt class="text-sm text-[#536b59]">{{ __('Date') }}</dt>
                    <dd class="text-right text-sm text-[#214b34]">{{ $donation->updated_at->format('M j, Y') }}</dd>
                </div>
                <div class="flex items-baseline justify-between gap-4 py-4">
                    <dt class="text-sm text-[#536b59]">{{ __('Status') }}</dt>
                    <dd class="text-sm font-medium text-[#22583d]">{{ __('Completed') }}</dd>
                </div>
                @if ($donation->stripe_payment_id || $donation->stripe_payment_intent_id)
                    <div class="flex flex-col gap-1 py-4 last:pb-0">
                        <dt class="text-sm text-[#536b59]">{{ __('Payment confirmation number') }}</dt>
                        <dd class="break-all font-mono text-xs text-[#214b34]">
                            {{ $donation->stripe_payment_id ?: $donation->stripe_payment_intent_id }}
                        </dd>
                    </div>
                @endif
            </dl>
        </section>

        <a
            href="{{ route('donation-history') }}"
            class="inline-flex rounded-md border border-[#9db99d] px-4 py-2 text-sm font-semibold text-[#214b34] hover:bg-[#e7f1e5] focus:outline-none focus:ring-2 focus:ring-[#58825f] focus:ring-offset-2"
        >
            {{ __('View donation history') }}
        </a>
    </div>
</x-layouts::app>