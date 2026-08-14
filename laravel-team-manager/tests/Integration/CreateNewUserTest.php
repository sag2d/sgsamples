<?php

use App\Actions\Fortify\CreateNewUser;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('create new user creates user record in database', function () {
    $action = new CreateNewUser();

    $user = $action->create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'Password123',
        'password_confirmation' => 'Password123',
    ]);

    expect($user)->toBeInstanceOf(User::class)
        ->and($user->name)->toBe('John Doe')
        ->and($user->email)->toBe('john@example.com')
        ->and(Hash::check('Password123', $user->password))->toBeTrue();
});

test('create new user hashes password', function () {
    $action = new CreateNewUser();

    $user = $action->create([
        'name' => 'Jane Smith',
        'email' => 'jane@example.com',
        'password' => 'SecurePass456',
        'password_confirmation' => 'SecurePass456',
    ]);

    expect($user->password)->not->toBe('SecurePass456');
});

test('create new user validates name is required', function () {
    $action = new CreateNewUser();

    try {
        $action->create([
            'name' => '',
            'email' => 'test@example.com',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
        ]);
        
        // validation didn't throw an error
        $this->fail('A ValidationException was expected but not thrown.');
    } catch (\Illuminate\Validation\ValidationException $e) {
        // exception was caught. assert the specified key failed validation.
        expect($e->errors())->toHaveKey('name');
    }
});

test('create new user validates email is required', function () {
    $action = new CreateNewUser();

    try {
        $action->create([
            'name' => 'John Doe',
            'email' => '',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
        ]);

        // validation didn't throw an error
        $this->fail('A ValidationException was expected but not thrown.');
    } catch (\Illuminate\Validation\ValidationException $e) {
        // exception was caught. assert the specified key failed validation.
        expect($e->errors())->toHaveKey('email');
    }
});

test('create new user validates email is unique', function () {
    User::factory()->create(['email' => 'taken@example.com']);

    $action = new CreateNewUser();

    try {
        $action->create([
            'name' => 'New User',
            'email' => 'taken@example.com',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
        ]);

        // validation didn't throw an error
        $this->fail('A ValidationException was expected but not thrown.');
    } catch (\Illuminate\Validation\ValidationException $e) {
        expect($e->errors())->toHaveKey('email');
    }
});

test('create new user validates password is required', function () {
    $action = new CreateNewUser();

    try {
        $action->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => '',
            'password_confirmation' => '',
        ]);

        // validation didn't throw an error
        $this->fail('A ValidationException was expected but not thrown.');
    } catch (\Illuminate\Validation\ValidationException $e) {
        expect($e->errors())->toHaveKey('password');
    }
});

test('create new user validates password must be confirmed', function () {
    $action = new CreateNewUser();

    try {
        $action->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'Password123',
            'password_confirmation' => 'DifferentPassword',
        ]);

        // validation didn't throw an error
        $this->fail('A ValidationException was expected but not thrown.');
    } catch (\Illuminate\Validation\ValidationException $e) {
        expect($e->errors())->toHaveKey('password');
    }
});

test('create new user validates password meets complexity requirements', function () {
    $action = new CreateNewUser();

    try {
        $action->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'weak',
            'password_confirmation' => 'weak',
        ]);

        // validation didn't throw an error
        $this->fail('A ValidationException was expected but not thrown.');
    } catch (\Illuminate\Validation\ValidationException $e) {
        expect($e->errors())->toHaveKey('password');
    }
});

test('create new user validates name length', function () {
    $action = new CreateNewUser();

    try {
        $action->create([
            'name' => str_repeat('a', 256),
            'email' => 'test@example.com',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
        ]);

        // validation didn't throw an error
        $this->fail('A ValidationException was expected but not thrown.');
    } catch (\Illuminate\Validation\ValidationException $e) {
        expect($e->errors())->toHaveKey('name');
    }
});

test('create new user validates email format', function () {
    $action = new CreateNewUser();

    try {
        $action->create([
            'name' => 'John Doe',
            'email' => 'invalid-email-format',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
        ]);

        // validation didn't throw an error
        $this->fail('A ValidationException was expected but not thrown.');
    } catch (\Illuminate\Validation\ValidationException $e) {
        expect($e->errors())->toHaveKey('email');
    }
});
