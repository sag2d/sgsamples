<x-layouts::public :title="__('Leagues')">
    <div class="flex w-full flex-1 flex-col gap-6">
        <div class="flex flex-col gap-1">
            <h1 class="text-2xl font-semibold text-neutral-900 dark:text-white">Leagues</h1>
            <p class="text-sm text-neutral-600 dark:text-neutral-400">Browse all available leagues.</p>
        </div>

        <div class="overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <ul class="divide-y divide-neutral-200 dark:divide-neutral-700">
                @forelse ($leagues as $league)
                    <li class="px-4 py-3 text-sm font-medium text-neutral-900 dark:text-white">
                        {{ $league->name }}
                    </li>
                @empty
                    <li class="px-4 py-8 text-center text-sm text-neutral-600 dark:text-neutral-400">
                        No leagues are available yet.
                    </li>
                @endforelse
            </ul>
        </div>
    </div>
</x-layouts::public>
