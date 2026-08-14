<?php

use App\Actions\Fortify\ResetUserPassword;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('reset user password updates password in database', function () {
    $user = User::factory()->create();
    $originalPassword = $user->password;

    $action = new ResetUserPassword();
    $action->reset($user, [
        'password' => 'NewPassword123',
        'password_confirmation' => 'NewPassword123',
    ]);

    $user->refresh();

    expect($user->password)->not->toBe($originalPassword)
        ->and(Hash::check('NewPassword123', $user->password))->toBeTrue();
});

test('reset user password hashes new password', function () {
    $user = User::factory()->create();

    $action = new ResetUserPassword();
    $action->reset($user, [
        'password' => 'PlainTextPassword',
        'password_confirmation' => 'PlainTextPassword',
    ]);

    $user->refresh();

    expect($user->password)->not->toBe('PlainTextPassword');
});

test('reset user password validates password is required', function () {
    $user = User::factory()->create();

    $action = new ResetUserPassword();

    try {
        $action->reset($user, [
            'password' => '',
            'password_confirmation' => '',
        ]);
    
        // validation didn't throw an error
        $this->fail('A ValidationException was expected but not thrown.');
    } catch (\Illuminate\Validation\ValidationException $e) {
        // exception was caught. assert the specified key failed validation.
        expect($e->errors())->toHaveKey('password');
    }
});

test('reset user password validates password must be confirmed', function () {
    $user = User::factory()->create();

    $action = new ResetUserPassword();

    try {
        $action->reset($user, [
            'password' => 'NewPassword123',
            'password_confirmation' => 'DifferentPassword',
        ]);
    
        // validation didn't throw an error
        $this->fail('A ValidationException was expected but not thrown.');
    } catch (\Illuminate\Validation\ValidationException $e) {
        // exception was caught. assert the specified key failed validation.
        expect($e->errors())->toHaveKey('password');
    }
});

test('reset user password validates password meets complexity requirements', function () {
    $user = User::factory()->create();

    $action = new ResetUserPassword();

    try {
        $action->reset($user, [
            'password' => 'weak',
            'password_confirmation' => 'weak',
        ]);
    
        // validation didn't throw an error
        $this->fail('A ValidationException was expected but not thrown.');
    } catch (\Illuminate\Validation\ValidationException $e) {
        // exception was caught. assert the specified key failed validation.
        expect($e->errors())->toHaveKey('password');
    }
});

test('reset user password does not throw on valid password', function () {
    $user = User::factory()->create();

    $action = new ResetUserPassword();

    expect(function () {
        $action->reset($user, [
            'password' => 'ValidPassword123',
            'password_confirmation' => 'ValidPassword123',
        ]);
    })->not->toThrow(\Throwable::class);
});

test('reset user password persists changes to database', function () {
    $user = User::factory()->create(['email' => 'user@example.com']);

    $action = new ResetUserPassword();
    $action->reset($user, [
        'password' => 'UpdatedPassword123',
        'password_confirmation' => 'UpdatedPassword123',
    ]);

    $retrievedUser = User::where('email', 'user@example.com')->first();

    expect(Hash::check('UpdatedPassword123', $retrievedUser->password))->toBeTrue();
});

test('reset user password can reset password multiple times', function () {
    $user = User::factory()->create();

    $action = new ResetUserPassword();

    // First reset
    $action->reset($user, [
        'password' => 'FirstPassword123',
        'password_confirmation' => 'FirstPassword123',
    ]);

    $user->refresh();
    $firstHash = $user->password;

    // Second reset
    $action->reset($user, [
        'password' => 'SecondPassword456',
        'password_confirmation' => 'SecondPassword456',
    ]);

    $user->refresh();

    expect($user->password)->not->toBe($firstHash)
        ->and(Hash::check('SecondPassword456', $user->password))->toBeTrue();
});
