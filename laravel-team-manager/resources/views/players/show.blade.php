<x-layouts::public :title="__($player->first_name . ' ' . $player->last_name)">
    <div class="flex w-full flex-1 flex-col gap-6">
        <div class="flex flex-col gap-1">
            <a href="{{ route('players.index') }}" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors duration-150">
                ← Back to Players
            </a>
            <h1 class="text-2xl font-semibold text-neutral-900 dark:text-white">{{ $player->first_name }} {{ $player->last_name }}</h1>
            <p class="text-sm text-neutral-600 dark:text-neutral-400">Player details and contact information.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Team Information -->
            @if ($team)
                <div class="border border-neutral-200 dark:border-neutral-700 rounded-lg p-4">
                    <h2 class="text-lg font-semibold text-neutral-900 dark:text-white mb-3">Team</h2>
                    <a href="{{ route('teams.show', $team) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors duration-150">
                        {{ $team->name }}
                    </a>
                </div>
            @endif

            <!-- Contact Information -->
            <div class="border border-neutral-200 dark:border-neutral-700 rounded-lg p-4">
                <h2 class="text-lg font-semibold text-neutral-900 dark:text-white mb-3">Contact</h2>
                <div class="flex flex-col gap-2 text-sm text-neutral-600 dark:text-neutral-400">
                    @if ($player->email)
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="font-medium text-neutral-900 dark:text-white">Email:</span>
                            <x-email-link :email="$player->email" />
                            <button
                                type="button"
                                data-copy-value="{{ $player->email }}"
                                aria-label="Copy email address"
                                class="rounded-md border border-neutral-300 px-2 py-1 text-xs font-medium text-neutral-700 transition-colors hover:bg-neutral-100 dark:border-neutral-600 dark:text-neutral-200 dark:hover:bg-neutral-700"
                            >
                                Copy
                            </button>
                        </div>
                    @endif
                    @if ($player->phone)
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="font-medium text-neutral-900 dark:text-white">Phone:</span>
                            <span>{{ $player->phone }}</span>
                            <button
                                type="button"
                                data-copy-value="{{ $player->phone }}"
                                aria-label="Copy phone number"
                                class="rounded-md border border-neutral-300 px-2 py-1 text-xs font-medium text-neutral-700 transition-colors hover:bg-neutral-100 dark:border-neutral-600 dark:text-neutral-200 dark:hover:bg-neutral-700"
                            >
                                Copy
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Address Information -->
            @if ($player->address || $player->city || $player->state_id)
                <div class="border border-neutral-200 dark:border-neutral-700 rounded-lg p-4 md:col-span-2">
                    <h2 class="text-lg font-semibold text-neutral-900 dark:text-white mb-3">Address</h2>
                    <div class="flex flex-col gap-1 text-sm text-neutral-600 dark:text-neutral-400">
                        @if ($player->address)
                            <div>{{ $player->address }}</div>
                        @endif
                        <div class="flex gap-2">
                            @if ($player->city)
                                <div>{{ $player->city }},</div>
                            @endif
                            @if ($state)
                                <div>{{ $state->abbr }}</div>
                            @endif
                            @if ($player->zip)
                                <div>{{ $player->zip }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layouts::public>
