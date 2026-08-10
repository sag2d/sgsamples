<x-layouts::public :title="__($league->name)">
    <div class="flex w-full flex-1 flex-col gap-6">
        <div class="flex flex-col gap-1">
            <a href="{{ route('leagues.index') }}" class="text-sm text-neutral-600 hover:text-neutral-900 dark:text-neutral-400 dark:hover:text-white">
                ← Back to Leagues
            </a>
            <h1 class="text-2xl font-semibold text-neutral-900 dark:text-white">{{ $league->name }}</h1>
            <p class="text-sm text-neutral-600 dark:text-neutral-400">Teams in this league.</p>
        </div>

        <ul class="flex flex-col gap-3 list-none">
            @forelse ($teams as $team)
                <li class="border border-neutral-200 dark:border-neutral-700 rounded-lg px-4 py-4 hover:bg-neutral-50 dark:hover:bg-neutral-900 transition-colors duration-150">
                    <div class="flex flex-col gap-1">
                        <div class="text-sm font-semibold text-neutral-900 dark:text-white">{{ $team->name }}</div>
                        @if ($team->mascot)
                            <div class="text-xs text-neutral-600 dark:text-neutral-400">Mascot: {{ $team->mascot }}</div>
                        @endif
                    </div>
                </li>
            @empty
                <li class="text-center py-8 text-sm text-neutral-600 dark:text-neutral-400">
                    No teams in this league yet.
                </li>
            @endforelse
        </ul>
    </div>
</x-layouts::public>
