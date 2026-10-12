<x-layouts::app :title="__('Donate')">
    <div
        class="mx-auto max-w-2xl space-y-8"
        x-data="donationPayment()"
        x-on:pageshow.window="processing = false"
    >
        <div class="space-y-3">
            <h1 class="text-2xl font-semibold text-neutral-900 dark:text-neutral-100">{{ __('Recurring Donation') }}</h1>
            <p class="text-neutral-600 dark:text-neutral-400">{{ __('Your recurring donation amount and interval.') }}</p>
            <p class="text-3xl font-semibold text-neutral-900 dark:text-neutral-100">${{ number_format($amount, 2) }} <span class="text-base font-normal text-neutral-600 dark:text-neutral-400">{{ __('per') }} {{ ucfirst($interval) }}</span></p>
        </div>

        <section class="space-y-6 rounded-lg border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
            <div id="payment-element"></div>
            <button
                id="submit"
                type="button"
                x-on:click="confirmDonation()"
                x-bind:disabled="processing"
                x-bind:aria-busy="processing"
                class="rounded-md bg-accent px-4 py-2 text-sm font-medium text-accent-foreground hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-accent focus:ring-offset-2 disabled:cursor-wait disabled:opacity-60"
            >
                <span x-show="!processing">{{ __('Donate Now') }}</span>
                <span x-show="processing" style="display: none">{{ __('Processing...') }}</span>
            </button>
        </section>
    </div>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe(@js(config('cashier.key')));

        const elements = stripe.elements({
            clientSecret: @js($clientSecret)
        });

        const paymentElement = elements.create('payment');

        paymentElement.mount('#payment-element');

        window.donationPayment = () => ({
            processing: false,
            async confirmDonation() {
                if (this.processing) {
                    return;
                }

                this.processing = true;

                try {
                    const { error } = await stripe.confirmSetup({
                        elements,
                        confirmParams: {
                            return_url: @js(route('donate-recurring.complete', ['amount' => $amount, 'interval' => $interval])),
                        },
                    });

                    if (error) {
                        alert('Payment error: ' + error.message);
                        this.processing = false;
                    }
                } catch (error) {
                    alert('Payment error: ' + error.message);
                    this.processing = false;
                }
            },
        });
    </script>
</x-layouts::app>