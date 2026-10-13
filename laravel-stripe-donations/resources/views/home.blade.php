<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="A clear, secure portal for one-time and recurring donations.">
        <title>{{ config('app.name', 'Stripe Donations') }} - Giving made clear</title>
        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">
        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.ts'])
    </head>
    <body class="min-h-screen bg-[#f2f8f1] font-sans text-[#183529] antialiased">
        <header class="border-b border-[#d6e4d5] bg-[#f8fbf7]">
            <nav class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-x-8 gap-y-4 px-5 py-4 md:px-8" aria-label="{{ __('Main navigation') }}">
                <a href="{{ route('home') }}" class="flex items-center gap-3 font-semibold text-[#183529]">
                    <x-app-logo-icon />
                    <span>{{ config('app.name', 'Stripe Donations') }}</span>
                </a>

                <div class="flex flex-wrap items-center gap-x-5 gap-y-2 text-sm font-medium">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-[#385745] transition hover:text-[#173f2b]">{{ __('Dashboard') }}</a>
                        <a href="{{ route('donate') }}" class="text-[#385745] transition hover:text-[#173f2b]">{{ __('Donate') }}</a>
                        <a href="{{ route('donation-history') }}" class="text-[#385745] transition hover:text-[#173f2b]">{{ __('Donation history') }}</a>
                    @else
                        <a href="{{ route('login') }}" class="text-[#385745] transition hover:text-[#173f2b]">{{ __('Log in') }}</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="rounded-md border border-[#9db99d] px-4 py-2 text-[#214b34] transition hover:bg-[#e7f1e5]">{{ __('Register') }}</a>
                        @endif
                    @endauth
                    <a href="/admin/login" class="text-xs text-[#64796a] transition hover:text-[#173f2b]">{{ __('Admin') }}</a>
                </div>
            </nav>
        </header>

        <main>
            <section class="border-b border-[#d6e4d5] bg-[#e7f1e5]">
                <div class="mx-auto grid max-w-7xl gap-12 px-5 py-16 md:px-8 md:py-24 lg:grid-cols-[1.1fr_0.9fr] lg:items-center">
                    <div class="max-w-2xl">
                        <p class="mb-5 text-xs font-semibold uppercase text-[#557a5e]">{{ __('A thoughtful way to give') }}</p>
                        <h1 class="text-5xl font-semibold leading-[1.05] text-[#173f2b] md:text-6xl">{{ config('app.name', 'Stripe Donations') }}</h1>
                        <p class="mt-6 max-w-xl text-lg leading-8 text-[#45614e]">
                            {{ __('Make a one-time contribution or set up a recurring donation in a secure, straightforward portal. Keep your giving and receipts together in one place.') }}
                        </p>

                        <div class="mt-8 flex flex-wrap items-center gap-4">
                            @auth
                                <a href="{{ route('donate') }}" class="inline-flex items-center justify-center rounded-md bg-[#22583d] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#19452f] focus:outline-none focus:ring-2 focus:ring-[#22583d] focus:ring-offset-2 focus:ring-offset-[#e7f1e5]">
                                    {{ __('Start a donation') }}
                                </a>
                                <a href="{{ route('donation-history') }}" class="text-sm font-semibold text-[#28573b] underline decoration-[#93ae91] underline-offset-4 transition hover:text-[#173f2b]">
                                    {{ __('View your history') }}
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-md bg-[#22583d] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#19452f] focus:outline-none focus:ring-2 focus:ring-[#22583d] focus:ring-offset-2 focus:ring-offset-[#e7f1e5]">
                                    {{ __('Log in to donate') }}
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="text-sm font-semibold text-[#28573b] underline decoration-[#93ae91] underline-offset-4 transition hover:text-[#173f2b]">
                                        {{ __('Create an account') }}
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </div>

                    <aside class="border-l-2 border-[#afc99d] pl-6 md:pl-9" aria-labelledby="giving-options-heading">
                        <p class="text-xs font-semibold uppercase text-[#75864f]">{{ __('Flexible giving') }}</p>
                        <h2 id="giving-options-heading" class="mt-3 text-2xl font-semibold text-[#173f2b]">{{ __('Choose what works for you') }}</h2>
                        <div class="mt-7 divide-y divide-[#cadbc5]">
                            <div class="grid grid-cols-[3rem_1fr] gap-4 py-5">
                                <span class="font-mono text-sm text-[#8a8d4b]">01</span>
                                <div>
                                    <h3 class="font-semibold text-[#214b34]">{{ __('One-time donation') }}</h3>
                                    <p class="mt-1 text-sm leading-6 text-[#536b59]">{{ __('Choose an amount and make a single contribution.') }}</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-[3rem_1fr] gap-4 py-5">
                                <span class="font-mono text-sm text-[#8a8d4b]">02</span>
                                <div>
                                    <h3 class="font-semibold text-[#214b34]">{{ __('Recurring donation') }}</h3>
                                    <p class="mt-1 text-sm leading-6 text-[#536b59]">{{ __('Choose a giving interval: daily, weekly, monthly, or yearly.') }}</p>
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            </section>

            <section class="mx-auto max-w-7xl px-5 py-16 md:px-8 md:py-20" aria-labelledby="portal-heading">
                <div class="max-w-2xl">
                    <p class="text-xs font-semibold uppercase text-[#75864f]">{{ __('Your giving, organized') }}</p>
                    <h2 id="portal-heading" class="mt-3 text-3xl font-semibold text-[#173f2b]">{{ __('One account. A clear record.') }}</h2>
                    <p class="mt-4 leading-7 text-[#536b59]">{{ __('Secure Stripe payment forms support your contributions. Your dashboard summarizes completed giving, and donation history keeps receipts and recurring schedules easy to revisit.') }}</p>
                </div>

                <div class="mt-10 grid gap-8 border-t border-[#d6e4d5] pt-8 md:grid-cols-3 md:gap-10">
                    <a href="{{ auth()->check() ? route('donate') : route('login') }}" class="group block border-b border-[#d6e4d5] pb-6 md:border-b-0 md:pb-0">
                        <span class="text-xs font-semibold uppercase text-[#8a8d4b]">{{ __('01 / Give') }}</span>
                        <h3 class="mt-3 text-xl font-semibold text-[#214b34] group-hover:text-[#173f2b]">{{ __('Make a donation') }}</h3>
                        <p class="mt-2 text-sm leading-6 text-[#536b59]">{{ __('Start a one-time gift or choose a recurring schedule.') }}</p>
                    </a>
                    <a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="group block border-b border-[#d6e4d5] pb-6 md:border-b-0 md:pb-0">
                        <span class="text-xs font-semibold uppercase text-[#8a8d4b]">{{ __('02 / Overview') }}</span>
                        <h3 class="mt-3 text-xl font-semibold text-[#214b34] group-hover:text-[#173f2b]">{{ __('Your dashboard') }}</h3>
                        <p class="mt-2 text-sm leading-6 text-[#536b59]">{{ __('See your total completed donations and yearly giving.') }}</p>
                    </a>
                    <a href="{{ auth()->check() ? route('donation-history') : route('login') }}" class="group block">
                        <span class="text-xs font-semibold uppercase text-[#8a8d4b]">{{ __('03 / Records') }}</span>
                        <h3 class="mt-3 text-xl font-semibold text-[#214b34] group-hover:text-[#173f2b]">{{ __('Donation history') }}</h3>
                        <p class="mt-2 text-sm leading-6 text-[#536b59]">{{ __('Review past contributions and manage active recurring donations.') }}</p>
                    </a>
                </div>
            </section>
        </main>

        <footer class="border-t border-[#d6e4d5] bg-[#e7f1e5]">
            <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-3 px-5 py-5 text-sm text-[#536b59] md:px-8">
                <span>{{ config('app.name', 'Stripe Donations') }}</span>
                <span>{{ __('Secure payment processing by Stripe.') }}</span>
            </div>
        </footer>
    </body>
</html>
