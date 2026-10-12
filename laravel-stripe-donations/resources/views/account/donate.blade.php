<x-layouts::app :title="__('Donate')">
    <div
        class="mx-auto max-w-2xl space-y-8"
        x-data="{ donationType: 'once', processing: false, processingType: null }"
        x-on:pageshow.window="processing = false; processingType = null"
    >
        <div>
            <h1 class="text-2xl font-semibold text-neutral-900 dark:text-neutral-100">{{ __('Make a Donation') }}</h1>
            <p class="mt-2 text-neutral-600 dark:text-neutral-400">{{ __('Choose an amount and donation schedule.') }}</p>
        </div>

        <form
            action="{{ route('donate-once') }}"
            method="GET"
            class="space-y-6"
            x-on:submit="processing = true; processingType = donationType"
        >
            <div class="max-w-sm">
                <label for="donation-type" class="mb-2 block text-sm font-medium text-neutral-900 dark:text-neutral-100">
                    {{ __('Donation type') }}
                </label>
                <select
                    id="donation-type"
                    name="donation_type"
                    x-model="donationType"
                    class="w-full rounded-md border border-neutral-300 bg-white px-3 py-2 text-neutral-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100"
                >
                    <option value="once">{{ __('One-Time') }}</option>
                    <option value="recurring">{{ __('Recurring') }}</option>
                </select>
            </div>

            <div class="max-w-sm">
                <label for="amount" class="mb-2 block text-sm font-medium text-neutral-900 dark:text-neutral-100">
                    {{ __('Donation amount (USD)') }}
                </label>
                <div class="flex items-center gap-2">
                    <span class="text-neutral-600 dark:text-neutral-400">$</span>
                    <input
                        id="amount"
                        name="amount"
                        type="number"
                        min="1"
                        step="1"
                        value="10"
                        required
                        class="w-full rounded-md border border-neutral-300 bg-white px-3 py-2 text-neutral-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100"
                    >
                </div>
            </div>

            <div class="max-w-sm" x-show="donationType === 'recurring'" style="display: none">
                <label for="interval" class="mb-2 block text-sm font-medium text-neutral-900 dark:text-neutral-100">
                    {{ __('Recurring interval') }}
                </label>
                <select
                    id="interval"
                    name="interval"
                    x-bind:disabled="donationType !== 'recurring' || processing"
                    class="w-full rounded-md border border-neutral-300 bg-white px-3 py-2 text-neutral-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100"
                >
                    @foreach (\App\Enums\DonationInterval::cases() as $interval)
                        <option value="{{ $interval->value }}" @selected($interval === \App\Enums\DonationInterval::Month)>
                            {{ __($interval->label()) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex flex-wrap gap-3">
                <button
                    type="submit"
                    data-donation-type="once"
                    formaction="{{ route('donate-once') }}"
                    x-show="donationType === 'once'"
                    x-bind:disabled="processing"
                    x-bind:aria-busy="processingType === 'once'"
                    class="rounded-md border border-neutral-300 px-4 py-2 text-sm font-medium text-neutral-900 hover:bg-neutral-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:cursor-wait disabled:opacity-60 dark:border-neutral-700 dark:text-neutral-100 dark:hover:bg-neutral-800"
                >
                    <span x-show="processingType !== 'once'">{{ __('Donate Once') }}</span>
                    <span x-show="processingType === 'once'" style="display: none">{{ __('Processing...') }}</span>
                </button>
                <button
                    type="submit"
                    data-donation-type="recurring"
                    formaction="{{ route('donate-recurring') }}"
                    x-show="donationType === 'recurring'"
                    style="display: none"
                    x-bind:disabled="processing"
                    x-bind:aria-busy="processingType === 'recurring'"
                    class="rounded-md border border-neutral-300 px-4 py-2 text-sm font-medium text-neutral-900 hover:bg-neutral-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:cursor-wait disabled:opacity-60 dark:border-neutral-700 dark:text-neutral-100 dark:hover:bg-neutral-800"
                >
                    <span x-show="processingType !== 'recurring'">{{ __('Donate Recurring') }}</span>
                    <span x-show="processingType === 'recurring'" style="display: none">{{ __('Processing...') }}</span>
                </button>
            </div>
        </form>
    </div>
</x-layouts::app>
