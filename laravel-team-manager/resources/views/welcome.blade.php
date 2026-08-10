<x-layouts::public :title="__('Welcome')">
    <div class="flex w-full flex-1 flex-col gap-6 justify-center items-center text-center">
        <div class="flex flex-col gap-2">
            <h1 class="text-4xl font-bold text-neutral-900 dark:text-white">{{ config('app.name', 'Team Manager') }}</h1>
            <p class="text-lg text-neutral-600 dark:text-neutral-400">Manage your leagues, teams, and players.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8 w-full max-w-3xl">
            <a href="{{ route('leagues.index') }}" class="border border-neutral-200 dark:border-neutral-700 rounded-lg p-6 hover:bg-neutral-50 dark:hover:bg-neutral-900 transition-colors duration-150">
                <div class="text-3xl mb-2">🏆</div>
                <h2 class="text-lg font-semibold text-neutral-900 dark:text-white mb-2">Leagues</h2>
                <p class="text-sm text-neutral-600 dark:text-neutral-400">Browse all available leagues.</p>
            </a>

            <a href="{{ route('teams.index') }}" class="border border-neutral-200 dark:border-neutral-700 rounded-lg p-6 hover:bg-neutral-50 dark:hover:bg-neutral-900 transition-colors duration-150">
                <div class="text-3xl mb-2">👥</div>
                <h2 class="text-lg font-semibold text-neutral-900 dark:text-white mb-2">Teams</h2>
                <p class="text-sm text-neutral-600 dark:text-neutral-400">Explore teams and their details.</p>
            </a>

            <a href="{{ route('players.index') }}" class="border border-neutral-200 dark:border-neutral-700 rounded-lg p-6 hover:bg-neutral-50 dark:hover:bg-neutral-900 transition-colors duration-150">
                <div class="text-3xl mb-2">👤</div>
                <h2 class="text-lg font-semibold text-neutral-900 dark:text-white mb-2">Players</h2>
                <p class="text-sm text-neutral-600 dark:text-neutral-400">View player information and profiles.</p>
            </a>
        </div>
    </div>
</x-layouts::public>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
        <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
            @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4">
                    @auth
                        <a
                            href="{{ route('dashboard') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                        >
                            Dashboard
                        </a>
                    @else
                        <!--
                        <a
                            href="{{ route('login') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                        >
                            Login
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                Register
                            </a>
                        @endif
                        -->
                        
                        <a
                            href="/admin/login"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                        >
                            Admin Login
                        </a>
                    @endauth
                </nav>
            @endif
        </header>

        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif
    </body>
</html>
