<x-layouts::app :title="__('Donation History')">
    <div class="mx-auto max-w-5xl space-y-6">
        <header>
            <h1 class="text-2xl font-semibold text-neutral-900 dark:text-neutral-100">{{ __('Donation History') }}</h1>
            <p class="mt-2 text-neutral-600 dark:text-neutral-400">{{ __('Review your donations and recurring schedules.') }}</p>
        </header>

        @if (session('status'))
            <div role="status" class="rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800 dark:border-green-800 dark:bg-green-950 dark:text-green-200">
                {{ session('status') }}
            </div>
        @endif

        <div class="overflow-hidden rounded-lg border border-neutral-200 dark:border-neutral-700">
            <div class="overflow-x-auto">
                <table class="w-full divide-y divide-neutral-200 text-left dark:divide-neutral-700">
                    <thead class="bg-neutral-50 text-xs font-medium uppercase text-neutral-600 dark:bg-neutral-900 dark:text-neutral-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">{{ __('Date') }}</th>
                            <th scope="col" class="px-4 py-3">{{ __('Amount') }}</th>
                            <th scope="col" class="px-4 py-3">{{ __('Type') }}</th>
                            <th scope="col" class="px-4 py-3">{{ __('Status') }}</th>
                            <th scope="col" class="px-4 py-3">{{ __('Subscription') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-200 bg-white text-sm dark:divide-neutral-700 dark:bg-neutral-950">
                        @forelse ($donations as $donation)
                            <tr>
                                <td class="whitespace-nowrap px-4 py-3 text-neutral-700 dark:text-neutral-300">
                                    {{ $donation->created_at->format('M j, Y') }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 font-medium text-neutral-900 dark:text-neutral-100">
                                    {{ strtoupper($donation->currency) }} {{ number_format((float) $donation->amount, 2) }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-neutral-700 dark:text-neutral-300">
                                    {{ $donation->interval ? ucfirst($donation->interval) : __('One-time') }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-neutral-700 dark:text-neutral-300">
                                    {{ ucfirst($donation->status->value) }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3">
                                    @if ($donation->subscription?->active() && ! $donation->subscription->canceled())
                                        <form
                                            method="POST"
                                            action="{{ route('donation-history.cancel', $donation) }}"
                                            data-confirmation="{{ __('Click OK to permanently stop this recurring donation.') }}"
                                            x-data="{ processing: false }"
                                            x-on:submit="if (! window.confirm($el.dataset.confirmation)) { $event.preventDefault(); return; } processing = true"
                                            x-on:pageshow.window="processing = false"
                                        >
                                            @csrf
                                            <button
                                                type="submit"
                                                x-bind:disabled="processing"
                                                x-bind:aria-busy="processing"
                                                class="rounded-md border border-red-300 px-3 py-1.5 text-sm font-medium text-red-700 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:border-red-800 dark:text-red-300 dark:hover:bg-red-950"
                                            >
                                                <span x-show="!processing">{{ __('Cancel') }}</span>
                                                <span x-show="processing" style="display: none">{{ __('Cancelling...') }}</span>
                                            </button>
                                        </form>
                                    @elseif ($donation->subscription?->canceled())
                                        <span class="text-neutral-600 dark:text-neutral-400">
                                            {{ __('Ends') }} {{ $donation->subscription->ends_at?->format('M j, Y') }}
                                        </span>
                                    @elseif ($donation->subscription)
                                        <span class="text-neutral-600 dark:text-neutral-400">
                                            {{ ucfirst(str_replace('_', ' ', $donation->subscription->stripe_status)) }}
                                        </span>
                                    @else
                                        <span class="text-neutral-500 dark:text-neutral-500">{{ __('N/A') }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-10 text-center text-neutral-600 dark:text-neutral-400">
                                    {{ __('You have no donations yet.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{ $donations->links() }}
    </div>
</x-layouts::app>
