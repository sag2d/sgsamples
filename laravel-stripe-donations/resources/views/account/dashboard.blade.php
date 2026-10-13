<x-layouts::app :title="__('Dashboard')">
    <div class="mx-auto w-full max-w-6xl space-y-8 px-5 py-8 md:px-8">
        <header class="space-y-2">
            <p class="text-xs font-semibold uppercase text-[#75864f]">{{ __('Your giving, organized') }}</p>
            <h1 class="text-3xl font-semibold text-[#173f2b]">{{ __('Donation Dashboard') }}</h1>
            <p class="text-[#536b59]">{{ __('Your completed donation summary (in USD).') }}</p>
        </header>

        <section class="grid gap-4 md:grid-cols-3" aria-label="{{ __('Donation statistics') }}">
            <article class="rounded-lg border border-[#d6e4d5] bg-[#f8fbf7] p-5">
                <h2 class="text-sm font-medium text-[#536b59]">{{ __('Total completed donations') }}</h2>
                <p class="mt-3 text-3xl font-semibold text-[#173f2b]">{{ number_format($totalDonations) }}</p>
            </article>

            <article class="rounded-lg border border-[#d6e4d5] bg-[#f8fbf7] p-5">
                <h2 class="text-sm font-medium text-[#536b59]">{{ __('Donated last year') }} <span class="text-[#75864f]">({{ $lastYear }})</span></h2>
                <p class="mt-3 text-3xl font-semibold text-[#173f2b]">${{ number_format((float) $lastYearAmount, 2) }}</p>
            </article>

            <article class="rounded-lg border border-[#d6e4d5] bg-[#f8fbf7] p-5">
                <h2 class="text-sm font-medium text-[#536b59]">{{ __('Donated this year') }} <span class="text-[#75864f]">({{ $thisYear }})</span></h2>
                <p class="mt-3 text-3xl font-semibold text-[#173f2b]">${{ number_format((float) $thisYearAmount, 2) }}</p>
            </article>
        </section>
    </div>
</x-layouts::app>
