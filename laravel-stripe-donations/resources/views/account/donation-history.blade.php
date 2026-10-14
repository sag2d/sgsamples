<x-layouts::app :title="__('Donation History')">
    <div class="mx-auto max-w-5xl space-y-6 px-5 py-8 md:px-8">
        <header>
            <p class="text-xs font-semibold uppercase text-[#75864f]">{{ __('Your giving, organized') }}</p>
            <h1 class="mt-2 text-3xl font-semibold text-[#173f2b]">{{ __('Donation History') }}</h1>
            <p class="mt-2 text-[#536b59]">{{ __('Review your donations and recurring schedules.') }}</p>
        </header>

        @if(session('error'))
            <div role="alert" class="rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800 dark:border-red-800 dark:bg-red-950 dark:text-red-200">
                {{ session('error') }}
            </div>
        @endif

        @if (session('status'))
            <div role="status" class="rounded-md border border-[#b8d1b2] bg-[#e7f1e5] px-4 py-3 text-sm text-[#22583d]">
                {{ session('status') }}
            </div>
        @endif

        <div class="overflow-hidden rounded-lg border border-[#d6e4d5]">
            <div class="overflow-x-auto">
                <table class="w-full divide-y divide-[#d6e4d5] text-left">
                    <thead class="bg-[#e7f1e5] text-xs font-semibold uppercase text-[#536b59]">
                        <tr>
                            <th scope="col" class="px-4 py-3">{{ __('Date') }}</th>
                            <th scope="col" class="px-4 py-3">{{ __('Amount') }}</th>
                            <th scope="col" class="px-4 py-3">{{ __('Type') }}</th>
                            <th scope="col" class="px-4 py-3">{{ __('Status') }}</th>
                            <th scope="col" class="px-4 py-3">{{ __('Subscription') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#d6e4d5] bg-[#f8fbf7] text-sm">
                        @forelse ($donations as $donation)
                            <tr>
                                <td class="whitespace-nowrap px-4 py-3 text-[#536b59]">
                                    {{ $donation->created_at->format('M j, Y') }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 font-medium text-[#214b34]">
                                    ${{ number_format((float) $donation->amount, 2) }} ({{ strtoupper($donation->currency) }})
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-[#536b59]">
                                    {{ $donation->interval ? ucfirst($donation->interval) : __('One-time') }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-[#536b59]">
                                    {{ ucfirst($donation->status->value) }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3">
                                    @if ($donation->subscription?->active() && ! $donation->subscription->canceled())
                                        <form
                                            method="POST"
                                            action="{{ route('donation-history.cancel', $donation) }}"
                                            data-confirmation="{{ __('Click OK to confirm you wish to permanently stop this recurring donation.') }}"
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
                                        <span class="text-[#536b59]">
                                            {{ __('Ends') }} {{ $donation->subscription->ends_at?->format('M j, Y') }}
                                        </span>
                                    @elseif ($donation->subscription)
                                        <span class="text-[#536b59]">
                                            {{ ucfirst(str_replace('_', ' ', $donation->subscription->stripe_status)) }}
                                        </span>
                                    @else
                                        <span class="text-[#75816d]">{{ __('N/A') }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-10 text-center text-[#536b59]">
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
