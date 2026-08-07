<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:header container class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <x-app-logo href="{{ route('home') }}" />

            <flux:navbar class="-mb-px">
                <flux:navbar.item :href="route('leagues.index')" :current="request()->routeIs('leagues.*')">
                    {{ __('Leagues') }}
                </flux:navbar.item>
            </flux:navbar>
        </flux:header>

        <main class="mx-auto flex w-full max-w-7xl flex-1 px-4 py-8 sm:px-6 lg:px-8">
            {{ $slot }}
        </main>

        @fluxScripts
    </body>
</html>
