<x-layouts::app :title="__('Dashboard')">
    <div class="mx-auto w-full max-w-6xl space-y-8">
        <header class="space-y-2">
            <h1 class="text-2xl font-semibold text-neutral-900 dark:text-neutral-100">{{ __('Donation Dashboard') }}</h1>
            <p class="text-neutral-600 dark:text-neutral-400">{{ __('Your completed donation summary (in USD).') }}</p>
        </header>

        <section class="grid gap-4 md:grid-cols-3" aria-label="{{ __('Donation statistics') }}">
            <article class="rounded-lg border border-neutral-200 bg-white p-5 dark:border-neutral-700 dark:bg-neutral-900">
                <h2 class="text-sm font-medium text-neutral-600 dark:text-neutral-400">{{ __('Total completed donations') }}</h2>
                <p class="mt-3 text-3xl font-semibold text-neutral-900 dark:text-neutral-100">{{ number_format($totalDonations) }}</p>
            </article>

            <article class="rounded-lg border border-neutral-200 bg-white p-5 dark:border-neutral-700 dark:bg-neutral-900">
                <h2 class="text-sm font-medium text-neutral-600 dark:text-neutral-400">{{ __('Donated last year') }} <span class="text-neutral-500">({{ $lastYear }})</span></h2>
                <p class="mt-3 text-3xl font-semibold text-neutral-900 dark:text-neutral-100">${{ number_format((float) $lastYearAmount, 2) }}</p>
            </article>

            <article class="rounded-lg border border-neutral-200 bg-white p-5 dark:border-neutral-700 dark:bg-neutral-900">
                <h2 class="text-sm font-medium text-neutral-600 dark:text-neutral-400">{{ __('Donated this year') }} <span class="text-neutral-500">({{ $thisYear }})</span></h2>
                <p class="mt-3 text-3xl font-semibold text-neutral-900 dark:text-neutral-100">${{ number_format((float) $thisYearAmount, 2) }}</p>
            </article>
        </section>
    </div>
</x-layouts::app>
