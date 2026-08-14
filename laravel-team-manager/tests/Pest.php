<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Base Test Case Configuration
|--------------------------------------------------------------------------
*/

// All test types extend Laravel's base TestCase
pest()->extend(TestCase::class)
    ->in('Feature', 'Integration', 'Unit');

/*
|--------------------------------------------------------------------------
| Database & Seeding
|--------------------------------------------------------------------------
*/

// Refresh database and run migrations for Integration tests
pest()->use(RefreshDatabase::class)
    ->in('Integration');

// Refresh database, run migrations, and seed the database for Feature tests
pest()->use(RefreshDatabase::class)
    ->beforeEach(function () {
        $this->seed();
    })
    ->in('Feature');

/*
|--------------------------------------------------------------------------
| Custom Global Helper Functions
|--------------------------------------------------------------------------
*/

/**
 * Clear the application cache before specific test scenarios.
 */
function clearCache(): void
{
    Illuminate\Support\Facades\Artisan::call('cache:clear');
}