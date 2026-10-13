@php
    $isDonationTheme = request()->routeIs(
        'dashboard',
        'donate',
        'donate-once',
        'donate-recurring',
        'donate-once.complete',
        'donate-recurring.complete',
        'donation-history',
    );
    $lightThemePaths = [
        route('dashboard', [], false),
        route('donate', [], false),
        route('donate-once', [], false),
        route('donate-recurring', [], false),
        route('donate-once.complete', [], false),
        route('donate-recurring.complete', [], false),
        route('donation-history', [], false),
    ];
@endphp
<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    data-light-theme-paths="{{ json_encode($lightThemePaths) }}"
    @class(['dark' => ! $isDonationTheme])
>
    <head>
        @include('partials.head')
    </head>
    <body @class([
        'min-h-screen',
        'bg-[#f2f8f1]' => $isDonationTheme,
        'bg-white dark:bg-zinc-800' => ! $isDonationTheme,
    ])>
        <flux:sidebar
            sticky
            collapsible="mobile"
            class="{{ $isDonationTheme ? 'border-e border-[#d6e4d5] bg-[#f8fbf7]' : 'border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900' }}"
        >
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <flux:sidebar.group :heading="__('Platform')" class="grid">
                    <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="" :href="route('donate')" :current="request()->routeIs('donate')" wire:navigate>
                        {{ __('Donate') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="" :href="route('donation-history')" :current="request()->routeIs('donation-history')" wire:navigate>
                        {{ __('Donation History') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>
            </flux:sidebar.nav>

            <flux:spacer />

            <!--
            <flux:sidebar.nav>
                <flux:sidebar.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit" target="_blank">
                    {{ __('Repository') }}
                </flux:sidebar.item>

                <flux:sidebar.item icon="book-open-text" href="https://laravel.com/docs/starter-kits#livewire" target="_blank">
                    {{ __('Documentation') }}
                </flux:sidebar.item>
            </flux:sidebar.nav>
            -->

            <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <flux:avatar
                                    :name="auth()->user()->name"
                                    :initials="auth()->user()->initials()"
                                />

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                    <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer"
                            data-test="logout-button"
                        >
                            {{ __('Log out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
