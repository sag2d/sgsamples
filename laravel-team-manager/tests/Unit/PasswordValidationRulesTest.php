<?php

use App\Concerns\PasswordValidationRules;
use Illuminate\Validation\Rules\Password;

test('password rules returns array', function () {
    $trait = new class {
        use PasswordValidationRules;

        public function getPasswordRules() {
            return $this->passwordRules();
        }
    };

    $rules = $trait->getPasswordRules();

    expect($rules)->toBeArray()
        ->and(count($rules))->toBe(4);
});

test('password rules includes required', function () {
    $trait = new class {
        use PasswordValidationRules;

        public function getPasswordRules() {
            return $this->passwordRules();
        }
    };

    $rules = $trait->getPasswordRules();

    expect($rules)->toContain('required');
});

test('password rules includes string', function () {
    $trait = new class {
        use PasswordValidationRules;

        public function getPasswordRules() {
            return $this->passwordRules();
        }
    };

    $rules = $trait->getPasswordRules();

    expect($rules)->toContain('string');
});

test('password rules includes confirmed', function () {
    $trait = new class {
        use PasswordValidationRules;

        public function getPasswordRules() {
            return $this->passwordRules();
        }
    };

    $rules = $trait->getPasswordRules();

    expect($rules)->toContain('confirmed');
});

test('password rules includes password rule', function () {
    $trait = new class {
        use PasswordValidationRules;

        public function getPasswordRules() {
            return $this->passwordRules();
        }
    };

    $rules = $trait->getPasswordRules();

    expect($rules)
        ->toHaveLength(4)
        ->and(collect($rules)->contains(fn ($rule) => $rule instanceof Password))->toBeTrue();
});

test('current password rules returns array', function () {
    $trait = new class {
        use PasswordValidationRules;

        public function getCurrentPasswordRules() {
            return $this->currentPasswordRules();
        }
    };

    $rules = $trait->getCurrentPasswordRules();

    expect($rules)->toBeArray()
        ->and(count($rules))->toBe(3);
});

test('current password rules includes required', function () {
    $trait = new class {
        use PasswordValidationRules;

        public function getCurrentPasswordRules() {
            return $this->currentPasswordRules();
        }
    };

    $rules = $trait->getCurrentPasswordRules();

    expect($rules)->toContain('required');
});

test('current password rules includes string', function () {
    $trait = new class {
        use PasswordValidationRules;

        public function getCurrentPasswordRules() {
            return $this->currentPasswordRules();
        }
    };

    $rules = $trait->getCurrentPasswordRules();

    expect($rules)->toContain('string');
});

test('current password rules includes current password', function () {
    $trait = new class {
        use PasswordValidationRules;

        public function getCurrentPasswordRules() {
            return $this->currentPasswordRules();
        }
    };

    $rules = $trait->getCurrentPasswordRules();

    expect($rules)->toContain('current_password');
});
