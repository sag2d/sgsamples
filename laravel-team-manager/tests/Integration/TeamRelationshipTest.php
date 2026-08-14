<?php

use App\Models\Team;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

test('it belongs to a league', function () {
    $team = Team::factory()->create();
    
    $relation = $team->league();

    expect($relation)
        ->toBeInstanceOf(BelongsTo::class)
        ->and($relation->getForeignKeyName())->toBe('league_id');
});
