<?php

use App\Models\League;
use App\Models\Team;
use Illuminate\Database\Eloquent\Relations\HasMany;

test('it has many teams', function () {
    $league = League::factory()->create();
    
    $relation = $league->teams();

    expect($relation)
        ->toBeInstanceOf(HasMany::class)
        ->and($relation->getRelated())->toBeInstanceOf(Team::class)
        ->and($relation->getForeignKeyName())->toBe('league_id');
});
