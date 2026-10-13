<x-layouts::app :title="__('Donate')">
    <div
        class="mx-auto max-w-2xl space-y-8"
        x-data="donationPayment()"
        x-on:pageshow.window="processing = false"
    >
        <div class="space-y-3">
            <p class="text-xs font-semibold uppercase text-[#75864f]">{{ __('One-time gift') }}</p>
            <h1 class="text-3xl font-semibold text-[#173f2b]">{{ __('One-Time Donation') }}</h1>
            <p class="text-[#536b59]">{{ __('Complete your one-time donation.') }}</p>
            <p class="text-3xl font-semibold text-[#173f2b]">${{ number_format($amount, 2) }}</p>
        </div>

        <section class="space-y-6 rounded-lg border border-[#d6e4d5] bg-[#f8fbf7] p-6">
            <div id="payment-element"></div>
            <button
                id="submit"
                type="button"
                x-on:click="confirmDonation()"
                x-bind:disabled="processing"
                x-bind:aria-busy="processing"
                class="rounded-md bg-[#22583d] px-4 py-2 text-sm font-semibold text-white hover:bg-[#19452f] focus:outline-none focus:ring-2 focus:ring-[#58825f] focus:ring-offset-2 disabled:cursor-wait disabled:opacity-60"
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
                    const { error } = await stripe.confirmPayment({
                        elements,
                        confirmParams: {
                            return_url: @js(route('donate-once.complete')),
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