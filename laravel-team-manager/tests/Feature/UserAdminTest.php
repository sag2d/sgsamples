<?php

use App\Models\User;

test('admin user can access filament panel', function () {
    $user = User::factory()->create(['is_admin' => true]);

    $panel = new \Filament\Panel;

    expect($user->canAccessPanel($panel))->toBeTrue();
});

test('non-admin user cannot access filament panel', function () {
    $user = User::factory()->create(['is_admin' => false]);

    $panel = new \Filament\Panel;

    expect($user->canAccessPanel($panel))->toBeFalse();
});