<x-layouts::public :title="__('Players')">
    <div class="flex w-full flex-1 flex-col gap-6">
        <div class="flex flex-col gap-1">
            <h1 class="text-2xl font-semibold text-neutral-900 dark:text-white">Players</h1>
            <p class="text-sm text-neutral-600 dark:text-neutral-400">Browse all available players.</p>
        </div>

        <form method="GET" class="flex gap-2">
            <input
                type="text"
                name="search"
                placeholder="Search players..."
                value="{{ $searchName }}"
                class="flex-1 px-4 py-2 text-sm border border-neutral-200 dark:border-neutral-700 rounded-lg bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white placeholder-neutral-600 dark:placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
            <button
                type="submit"
                class="px-4 py-2 text-sm font-medium bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-150"
            >
                Search
            </button>
            @if ($searchName)
                <a
                    href="{{ route('players.index') }}"
                    class="px-4 py-2 text-sm font-medium border border-neutral-200 dark:border-neutral-700 text-neutral-900 dark:text-white rounded-lg hover:bg-neutral-50 dark:hover:bg-neutral-900 transition-colors duration-150"
                >
                    Clear
                </a>
            @endif
        </form>

        <ul class="flex flex-col gap-3 list-none">
            @forelse ($players as $player)
                <li class="border border-neutral-200 dark:border-neutral-700 rounded-lg overflow-hidden">
                    <a href="{{ route('players.show', $player) }}" class="block px-4 py-4 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors duration-150 text-sm font-medium hover:bg-neutral-50 dark:hover:bg-neutral-900">
                        {{ $player->first_name }} {{ $player->last_name }}
                    </a>
                </li>
            @empty
                <li class="text-center py-8 text-sm text-neutral-600 dark:text-neutral-400">
                    No players are available. Try adjusting your search.
                </li>
            @endforelse
        </ul>

        <div class="mt-6">
            {{ $players->appends(request()->query())->links() }}
        </div>
    </div>
</x-layouts::public>
