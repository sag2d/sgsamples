@php
    $isLightAuthRoute = request()->routeIs('login', 'register');
    $lightThemePaths = [
        route('login', [], false),
        route('register', [], false),
    ];
@endphp
<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    data-light-theme-paths="{{ json_encode($lightThemePaths) }}"
    @class(['dark' => ! $isLightAuthRoute])
>
    <head>
        @include('partials.head')
    </head>
    <body @class([
        'min-h-screen antialiased',
        'bg-[#e7f1e5] text-[#183529]' => $isLightAuthRoute,
        'bg-white dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900' => ! $isLightAuthRoute,
    ])>
        <div @class([
            'flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10',
            'bg-[#e7f1e5]' => $isLightAuthRoute,
            'bg-background' => ! $isLightAuthRoute,
        ])>
            <div class="flex w-full max-w-sm flex-col gap-2">
                <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 font-medium" wire:navigate>
                    <x-app-logo-icon />
                    <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
                </a>
                <div @class([
                    'flex flex-col gap-6',
                    'rounded-lg border border-[#d6e4d5] bg-[#f8fbf7] p-7 shadow-sm [--color-accent:#22583d] [--color-accent-content:#22583d] [--color-accent-foreground:#ffffff]' => $isLightAuthRoute,
                ])>
                    {{ $slot }}
                </div>
            </div>
        </div>

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
