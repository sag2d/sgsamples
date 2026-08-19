<x-layouts::public :title="__($team->name)">
    <div class="flex w-full flex-1 flex-col gap-6">
        <div class="flex flex-col gap-1">
            <a href="{{ route('teams.index') }}" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors duration-150">
                ← Back to Teams
            </a>
            <h1 class="text-2xl font-semibold text-neutral-900 dark:text-white">{{ $team->name }}</h1>
            <span class="text-sm text-neutral-600 dark:text-neutral-400">
                <a href="{{ route('leagues.show', $league) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors duration-150">
                    {{ $league->name }}
                </a>
            </span>
            @if ($team->mascot)
                <p class="text-sm text-neutral-600 dark:text-neutral-400">Mascot: {{ $team->mascot }}</p>
            @endif
            <p class="text-sm text-neutral-600 dark:text-neutral-400">Players on this team.</p>
        </div>

        <ul class="flex flex-col gap-3 list-none">
            @forelse ($players as $player)
                <li class="border border-neutral-200 dark:border-neutral-700 rounded-lg px-4 py-4 hover:bg-neutral-50 dark:hover:bg-neutral-900 transition-colors duration-150">
                    <a href="{{ route('players.show', $player) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors duration-150">
                        <div class="flex flex-col gap-1">
                            <div class="text-sm font-semibold">{{ $player->first_name }} {{ $player->last_name }}</div>
                            @if ($player->position)
                                <div class="text-xs">Position: {{ $player->position }}</div>
                            @endif
                        </div>
                    </a>
                </li>
            @empty
                <li class="text-center py-8 text-sm text-neutral-600 dark:text-neutral-400">
                    No players on this team yet.
                </li>
            @endforelse
        </ul>
    </div>
</x-layouts::public>
