<x-layouts::public :title="__('Welcome')">
    <div class="flex w-full flex-1 flex-col gap-6 justify-center items-center text-center">
        <div class="flex flex-col gap-2">
            <h1 class="text-4xl font-bold text-neutral-600 dark:text-neutral-400">{{ config('app.name', 'Team Manager') }}</h1>
            <p class="text-lg text-neutral-900 dark:text-white">Manage your leagues, teams, and players.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8 w-full max-w-3xl">
            <a href="{{ route('leagues.index') }}" class="flex flex-col items-center text-center border border-neutral-200 dark:border-neutral-700 rounded-lg p-6 hover:bg-neutral-50 dark:hover:bg-neutral-900 transition-colors duration-150">
                <!-- Trophy icon wrapper -->
                <div class="w-14 h-14 rounded-xl flex items-center justify-center mb-2">
                    <svg class="w-8 h-8 text-amber-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M7 3h10a1 1 0 011 1v1h2a1 1 0 011 1v1c0 2.5-1.8 4.5-4.2 4.9A6 6 0 0113 15.9V18h2a1 1 0 011 1v1a1 1 0 01-1 1H9a1 1 0 01-1-1v-1a1 1 0 011-1h2v-2.1A6 6 0 017.2 10.9C4.8 10.5 3 8.5 3 6V5a1 1 0 011-1h2V3a1 1 0 011-1zm0 4H5c0 1.5 1 2.7 2.4 3-.2-.6-.4-1.3-.4-2V7zm10 0v1c0 .7-.1 1.4-.4 2C18 9.7 19 8.5 19 7h-2z"/>
                    </svg>
                </div>
                <h2 class="text-lg font-semibold text-neutral-900 dark:text-white mb-2">Leagues</h2>
                <p class="text-sm text-neutral-600 dark:text-neutral-400">Browse all available leagues.</p>
            </a>

            <a href="{{ route('teams.index') }}" class="flex flex-col items-center text-center border border-neutral-200 dark:border-neutral-700 rounded-lg p-6 hover:bg-neutral-50 dark:hover:bg-neutral-900 transition-colors duration-150">
                <!-- Teams icon -->
                <div class="w-14 h-14 rounded-xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-indigo-500" fill="currentColor" viewBox="0 0 24 24">
                        <circle cx="12" cy="7" r="3.2"/>
                        <path d="M12 11.5c-3.5 0-6.5 2-6.5 5v2.5a1 1 0 001 1h11a1 1 0 001-1V16.5c0-3-3-5-6.5-5z"/>
                        <circle cx="4.5" cy="9.5" r="2.3" opacity="0.65"/>
                        <path d="M4.5 13c-2.2 0-4 1.4-4 3.5V18a.8.8 0 00.8.8H5.2" opacity="0.65"/>
                        <circle cx="19.5" cy="9.5" r="2.3" opacity="0.65"/>
                        <path d="M19.5 13c2.2 0 4 1.4 4 3.5V18a.8.8 0 01-.8.8h-3.9" opacity="0.65"/>
                    </svg>
                </div>
                <h2 class="text-lg font-semibold text-neutral-900 dark:text-white mb-2">Teams</h2>
                <p class="text-sm text-neutral-600 dark:text-neutral-400">Explore teams and their details.</p>
            </a>

            <a href="{{ route('players.index') }}" class="flex flex-col items-center text-center border border-neutral-200 dark:border-neutral-700 rounded-lg p-6 hover:bg-neutral-50 dark:hover:bg-neutral-900 transition-colors duration-150">
                <!-- Player icon -->
                <div class="w-14 h-14 rounded-xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-emerald-500" fill="currentColor" viewBox="0 0 24 24">
                        <circle cx="12" cy="7" r="4"/>
                        <path d="M12 13c-4.4 0-8 2.5-8 6v1a1 1 0 001 1h14a1 1 0 001-1v-1c0-3.5-3.6-6-8-6z"/>
                    </svg>
                </div>
                <h2 class="text-lg font-semibold text-neutral-900 dark:text-white mb-2">Players</h2>
                <p class="text-sm text-neutral-600 dark:text-neutral-400">View player information and profiles.</p>
            </a>
        </div>

        <div class="flex flex-col gap-2">
            <a
                href="/admin/login"
                target="_blank"
                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] hover:bg-neutral-50 dark:hover:bg-neutral-900 border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
            >
                Admin Login
            </a>
        </div>
    </div>
    
</x-layouts::public>
 