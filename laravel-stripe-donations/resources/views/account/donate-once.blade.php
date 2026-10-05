<x-layouts::app :title="__('Dashboard')">
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
            const { error } = await stripe.confirmPayment({
                elements,
                confirmParams: {
                    return_url: '{{ route("donate-once.complete") }}',
                },
            });

            if (error) {
                // Display "error.message" to the user...
            }
        });
    </script>
</x-layouts::app>