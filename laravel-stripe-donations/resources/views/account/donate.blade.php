<x-layouts::app :title="__('Donate')">
    <div class="mx-auto max-w-2xl space-y-8">
        <div>
            <h1 class="text-2xl font-semibold text-neutral-900 dark:text-neutral-100">{{ __('Make a Donation') }}</h1>
            <p class="mt-2 text-neutral-600 dark:text-neutral-400">{{ __('Choose an amount and donation schedule.') }}</p>
        </div>

        <form action="{{ route('donate-once') }}" method="GET" class="space-y-6">
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

            <div class="flex flex-wrap gap-3">
                <button
                    type="submit"
                    formaction="{{ route('donate-once') }}"
                    class="rounded-md border border-neutral-300 px-4 py-2 text-sm font-medium text-neutral-900 hover:bg-neutral-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:border-neutral-700 dark:text-neutral-100 dark:hover:bg-neutral-800"
                >
                    {{ __('Donate Once') }}
                </button>
                <button
                    type="submit"
                    formaction="{{ route('donate-recurring') }}"
                    class="rounded-md border border-neutral-300 px-4 py-2 text-sm font-medium text-neutral-900 hover:bg-neutral-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:border-neutral-700 dark:text-neutral-100 dark:hover:bg-neutral-800"
                >
                    {{ __('Donate Recurring') }}
                </button>
            </div>
        </form>
    </div>
</x-layouts::app>
