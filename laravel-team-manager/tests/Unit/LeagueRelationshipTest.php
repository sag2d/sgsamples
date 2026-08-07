<?php

use App\Models\League;
use App\Models\Team;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;

uses(TestCase::class);

test('it has many teams', function () {
    $relation = (new League)->teams();

    expect($relation)
        ->toBeInstanceOf(HasMany::class)
        ->and($relation->getRelated())->toBeInstanceOf(Team::class)
        ->and($relation->getForeignKeyName())->toBe('league_id');
});
