<?php

test('the player detail view provides copy controls for contact information', function () {
    $view = file_get_contents(__DIR__.'/../../resources/views/players/show.blade.php');
    $script = file_get_contents(__DIR__.'/../../resources/js/app.ts');

    expect($view)
        ->toContain('data-copy-value="{{ $player->email }}"')
        ->toContain('data-copy-value="{{ $player->phone }}"')
        ->and($script)->toContain('navigator.clipboard.writeText')
        ->not->toContain('document.execCommand')
        ->toContain("button.textContent = copied ? 'Copied!' : 'Unable to copy';");
});
