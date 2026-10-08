<x-layouts::app :title="__('Dashboard')">
    <div>
        <h1>{{ __('Recurring Donation') }}</h1>
        <p>${{ number_format($amount, 2) }}</p>
    </div>
    <div id="payment-element"></div>
    <button id="submit">Donate Now</button>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe('{{ config('cashier.key') }}');

        const elements = stripe.elements({
            clientSecret: '{{ $clientSecret }}'
        });

        const paymentElement = elements.create('payment');

        paymentElement.mount('#payment-element');

        document.getElementById('submit').addEventListener('click', async () => {
            const { error } = await stripe.confirmSetup({
                elements,
                confirmParams: {
                    return_url: '{{ route("donate-recurring.complete", ["amount" => $amount]) }}',
                },
            });

            if (error) {
                alert('Payment error: ' + error.message);
            }
        });
    </script>
</x-layouts::app>