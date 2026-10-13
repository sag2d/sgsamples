<x-layouts::app :title="__('Donate')">
    <div
        class="mx-auto max-w-2xl space-y-8"
        data-donation-payment
        data-stripe-key="{{ config('cashier.key') }}"
        data-client-secret="{{ $clientSecret }}"
        data-return-url="{{ route('donate-recurring.complete', ['donation_id' => $donationId]) }}"
    >
        <div class="space-y-3">
            <p class="text-xs font-semibold uppercase text-[#75864f]">{{ __('Recurring gift') }}</p>
            <h1 class="text-3xl font-semibold text-[#173f2b]">{{ __('Recurring Donation') }}</h1>
            <p class="text-[#536b59]">{{ __('Your recurring donation amount and interval.') }}</p>
            <p class="text-3xl font-semibold text-[#173f2b]">${{ number_format($amount, 2) }} <span class="text-base font-normal text-[#536b59]">{{ __('per') }} {{ ucfirst($interval) }}</span></p>
        </div>

        <section class="space-y-6 rounded-lg border border-[#d6e4d5] bg-[#f8fbf7] p-6">
            <div data-payment-element></div>
            <button
                data-donation-submit
                type="button"
                disabled
                aria-busy="true"
                class="rounded-md bg-[#22583d] px-4 py-2 text-sm font-semibold text-white hover:bg-[#19452f] focus:outline-none focus:ring-2 focus:ring-[#58825f] focus:ring-offset-2 disabled:cursor-wait disabled:opacity-60"
            >
                <span data-submit-label>{{ __('Donate Now') }}</span>
                <span data-processing-label hidden>{{ __('Processing...') }}</span>
            </button>
            <p data-donation-error role="alert" class="text-sm text-red-700" hidden></p>
        </section>
    </div>

    <script>
        (() => {
            const paymentForm = document.querySelector('[data-donation-payment]');

            if (paymentForm) {
                paymentForm.donationConfirmation = (stripe, elements, returnUrl) => stripe.confirmSetup({
                    elements,
                    confirmParams: { return_url: returnUrl },
                });
            }
        })();
    </script>
</x-layouts::app>