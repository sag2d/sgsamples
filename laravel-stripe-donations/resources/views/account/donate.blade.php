<x-layouts::app :title="__('Donate')">
    <div
        class="mx-auto max-w-2xl space-y-8"
        x-data="{ donationType: 'once', processing: false, processingType: null }"
        x-on:pageshow.window="processing = false; processingType = null"
    >
        <div>
            <p class="text-xs font-semibold uppercase text-[#75864f]">{{ __('A thoughtful way to give') }}</p>
            <h1 class="text-3xl font-semibold text-[#173f2b]">{{ __('Make a Donation') }}</h1>
            <p class="mt-2 text-[#536b59]">{{ __('Choose an amount and donation schedule.') }}</p>
        </div>

        <form
            action="{{ route('donate-once') }}"
            method="GET"
            class="space-y-6"
            x-on:submit="processing = true; processingType = donationType"
        >
            <div class="max-w-sm">
                <label for="donation-type" class="mb-2 block text-sm font-medium text-[#214b34]">
                    {{ __('Donation type') }}
                </label>
                <select
                    id="donation-type"
                    name="donation_type"
                    x-model="donationType"
                    class="w-full rounded-md border border-[#b8cdb4] bg-[#f8fbf7] px-3 py-2 text-[#183529] shadow-sm focus:border-[#58825f] focus:outline-none focus:ring-2 focus:ring-[#58825f]"
                >
                    <option value="once">{{ __('One-Time') }}</option>
                    <option value="recurring">{{ __('Recurring') }}</option>
                </select>
            </div>

            <div class="max-w-sm">
                <label for="amount" class="mb-2 block text-sm font-medium text-[#214b34]">
                    {{ __('Donation amount (USD)') }}
                </label>
                <div class="flex items-center gap-2">
                    <span class="text-[#536b59]">$</span>
                    <input
                        id="amount"
                        name="amount"
                        type="number"
                        min="1"
                        step="1"
                        value="10"
                        required
                        class="w-full rounded-md border border-[#b8cdb4] bg-[#f8fbf7] px-3 py-2 text-[#183529] shadow-sm focus:border-[#58825f] focus:outline-none focus:ring-2 focus:ring-[#58825f]"
                    >
                </div>
            </div>

            <div class="max-w-sm" x-show="donationType === 'recurring'" style="display: none">
                <label for="interval" class="mb-2 block text-sm font-medium text-[#214b34]">
                    {{ __('Recurring interval') }}
                </label>
                <select
                    id="interval"
                    name="interval"
                    x-bind:disabled="donationType !== 'recurring' || processing"
                    class="w-full rounded-md border border-[#b8cdb4] bg-[#f8fbf7] px-3 py-2 text-[#183529] shadow-sm focus:border-[#58825f] focus:outline-none focus:ring-2 focus:ring-[#58825f]"
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
                    class="rounded-md bg-[#22583d] px-4 py-2 text-sm font-semibold text-white hover:bg-[#19452f] focus:outline-none focus:ring-2 focus:ring-[#58825f] focus:ring-offset-2 disabled:cursor-wait disabled:opacity-60"
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
                    class="rounded-md border border-[#9db99d] px-4 py-2 text-sm font-semibold text-[#214b34] hover:bg-[#e7f1e5] focus:outline-none focus:ring-2 focus:ring-[#58825f] focus:ring-offset-2 disabled:cursor-wait disabled:opacity-60"
                >
                    <span x-show="processingType !== 'recurring'">{{ __('Donate Recurring') }}</span>
                    <span x-show="processingType === 'recurring'" style="display: none">{{ __('Processing...') }}</span>
                </button>
            </div>
        </form>
    </div>
</x-layouts::app>
