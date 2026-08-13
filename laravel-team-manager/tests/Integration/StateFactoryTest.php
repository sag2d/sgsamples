<?php

use App\Models\State;

test('it generates all fifty states', function () {
    $states = State::factory()->allStates()->make();

    expect($states)
        ->toHaveCount(50)
        ->and($states->pluck('name')->unique())->toHaveCount(50)
        ->and($states->pluck('abbr')->unique())->toHaveCount(50)
        ->and($states->first()->only(['name', 'abbr']))->toBe([
            'name' => 'Alabama',
            'abbr' => 'AL',
        ])
        ->and($states->last()->only(['name', 'abbr']))->toBe([
            'name' => 'Wyoming',
            'abbr' => 'WY',
        ]);
});
