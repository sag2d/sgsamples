<?php

use App\Concerns\ProfileValidationRules;
use App\Models\User;
use Illuminate\Validation\Rule;

test('profile rules returns array with name and email keys', function () {
    $trait = new class {
        use ProfileValidationRules;

        public function getProfileRules() {
            return $this->profileRules();
        }
    };

    $rules = $trait->getProfileRules();

    expect($rules)->toBeArray()
        ->and($rules)->toHaveKeys(['name', 'email']);
});

test('name rules includes required', function () {
    $trait = new class {
        use ProfileValidationRules;

        public function getNameRules() {
            return $this->nameRules();
        }
    };

    $rules = $trait->getNameRules();

    expect($rules)->toContain('required');
});

test('name rules includes string', function () {
    $trait = new class {
        use ProfileValidationRules;

        public function getNameRules() {
            return $this->nameRules();
        }
    };

    $rules = $trait->getNameRules();

    expect($rules)->toContain('string');
});

test('name rules includes max constraint', function () {
    $trait = new class {
        use ProfileValidationRules;

        public function getNameRules() {
            return $this->nameRules();
        }
    };

    $rules = $trait->getNameRules();

    expect($rules)->toContain('max:255');
});

test('email rules includes required', function () {
    $trait = new class {
        use ProfileValidationRules;

        public function getEmailRules() {
            return $this->emailRules();
        }
    };

    $rules = $trait->getEmailRules();

    expect($rules)->toContain('required');
});

test('email rules includes string', function () {
    $trait = new class {
        use ProfileValidationRules;

        public function getEmailRules() {
            return $this->emailRules();
        }
    };

    $rules = $trait->getEmailRules();

    expect($rules)->toContain('string');
});

test('email rules includes email', function () {
    $trait = new class {
        use ProfileValidationRules;

        public function getEmailRules() {
            return $this->emailRules();
        }
    };

    $rules = $trait->getEmailRules();

    expect($rules)->toContain('email');
});

test('email rules includes max constraint', function () {
    $trait = new class {
        use ProfileValidationRules;

        public function getEmailRules() {
            return $this->emailRules();
        }
    };

    $rules = $trait->getEmailRules();

    expect($rules)->toContain('max:255');
});

test('email rules includes unique rule when userId is null', function () {
    $trait = new class {
        use ProfileValidationRules;

        public function getEmailRules(?int $userId = null) {
            return $this->emailRules($userId);
        }
    };

    $rules = $trait->getEmailRules();

    expect(collect($rules)->contains(fn ($rule) => 
        is_object($rule) && str_contains($rule::class, 'Unique')
    ))->toBeTrue();
});

test('email rules ignores user id when provided', function () {
    $trait = new class {
        use ProfileValidationRules;

        public function getEmailRules(?int $userId = null) {
            return $this->emailRules($userId);
        }
    };

    $rulesWithId = $trait->getEmailRules(userId: 123);

    expect(collect($rulesWithId)->contains(fn ($rule) => 
        is_object($rule) && str_contains($rule::class, 'Unique')
    ))->toBeTrue();
});

test('profile rules returns different email rules for update vs create', function () {
    $trait = new class {
        use ProfileValidationRules;

        public function getProfileRules(?int $userId = null) {
            return $this->profileRules($userId);
        }
    };

    $createRules = $trait->getProfileRules();
    $updateRules = $trait->getProfileRules(userId: 42);

    expect($createRules['email'])->not->toBe($updateRules['email']);
});
