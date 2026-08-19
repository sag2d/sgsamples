<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:header container class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <!--x-app-logo href="{{ route('home') }}" /-->

            <flux:navbar class="-mb-px">
                <flux:navbar.item :href="route('home')" :current="request()->routeIs('home')">
                    {{ __('Home') }}
                </flux:navbar.item>
                <flux:navbar.item :href="route('leagues.index')" :current="request()->routeIs('leagues.*')">
                    {{ __('Leagues') }}
                </flux:navbar.item>
                <flux:navbar.item :href="route('teams.index')" :current="request()->routeIs('teams.*')">
                    {{ __('Teams') }}
                </flux:navbar.item>
                <flux:navbar.item :href="route('players.index')" :current="request()->routeIs('players.*')">
                    {{ __('Players') }}
                </flux:navbar.item>
            </flux:navbar>
            <nav class="flex w-full items-center justify-end gap-4">
                <a
                    href="/admin/login"
                    target="_blank"
                    class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] hover:bg-zinc-800/5 dark:hover:bg-white/10 border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                >
                    Admin Login
                </a>
            </nav>
        </flux:header>

        <main class="mx-auto flex w-full max-w-7xl flex-1 px-4 py-8 sm:px-6 lg:px-8">
            {{ $slot }}
        </main>

        @fluxScripts

        <footer class="mx-auto flex w-full max-w-7xl flex-col gap-4 px-4 py-8 sm:px-6 lg:px-8">
            @include('partials.footer')
        </footer>
    </body>
</html>
