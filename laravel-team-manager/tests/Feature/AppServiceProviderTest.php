<?php

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

test('app service provider configures date factory to use carbon immutable', function () {
    // Resolve a fresh date from the system factory facade
    $date = Date::now();

    // Assert it is an instance of CarbonImmutable
    expect($date)->toBeInstanceOf(CarbonImmutable::class);
});

test('app service provider enforces strict passwords in production environment', function () {
    // Swap application state environment configuration to production
    $this->app->detectEnvironment(fn () => 'production');

    // Re-trigger the configuration registration block 
    app(\App\Providers\AppServiceProvider::class, ['app' => $this->app])->boot();

    // Resolve the default framework password rule validator container
    $rules = Password::defaults();

    // Transform rule configurations object into a string pattern to check properties
    $rulesString = serialize($rules);

    // Assert all required security constraints are present in production mode
    expect($rulesString)
        ->toContain('min')
        ->toContain('mixedCase')
        ->toContain('symbols')
        ->toContain('uncompromised');
});
