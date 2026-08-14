<?php

use App\Models\User;

test('it generates a single user with an email address', function () {
    $user = User::factory()->make();

    expect($user)
        ->toBeInstanceOf(User::class)
        ->and($user->name)->toBeString()->not->toBeEmpty()
        ->and($user->email)->toBeString()
        ->and($user->email)->not->toBeEmpty()
        ->and($user->email)->toBeString()->toContain('@');
});

test('it generates users with unique email addresses', function () {
    $users = User::factory()->count(5)->make();

    expect($users)
        ->toHaveCount(5)
        ->and($users->pluck('email')->unique())->toHaveCount(5);
});

test('user has required attributes', function () {
    $user = User::factory()->create(['name' => 'John Doe', 'email' => 'john@example.com']);

    expect($user->name)->toBe('John Doe')
        ->and($user->email)->toBe('john@example.com')
        ->and($user->id)->toBeInt();
});

test('user password is hashed', function () {
    $user = User::factory()->create(['password' => 'password']);

    expect($user->password)->not->toBe('password');
});

test('user can generate initials from name', function () {
    $user = User::factory()->create(['name' => 'John Doe']);

    expect($user->initials())->toBe('JD');
});

test('user with single name generates single initial', function () {
    $user = User::factory()->create(['name' => 'Madonna']);

    expect($user->initials())->toBe('M');
});

test('user with multiple word name generates correct initials', function () {
    $user = User::factory()->create(['name' => 'Mary Jane Watson']);

    expect($user->initials())->toBe('MW');
});

test('user password and tokens are hidden', function () {
    $user = User::factory()->create();

    $hidden = $user->getHidden();

    expect($hidden)->toContain('password')
        ->and($hidden)->toContain('two_factor_secret')
        ->and($hidden)->toContain('two_factor_recovery_codes')
        ->and($hidden)->toContain('remember_token');
});

test('user is not admin by default', function () {
    $user = User::factory()->create();

    expect($user->is_admin)->toBeFalsy();
});