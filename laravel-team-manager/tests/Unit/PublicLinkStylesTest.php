<?php

test('league and team show links use the listing link color', function () {
    $leagueView = file_get_contents(__DIR__.'/../../resources/views/leagues/show.blade.php');
    $teamView = file_get_contents(__DIR__.'/../../resources/views/teams/show.blade.php');

    expect($leagueView)
        ->toContain('text-blue-600')
        ->and($teamView)->toContain('text-blue-600');
});
