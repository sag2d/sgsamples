<?php

namespace Database\Seeders;

use App\Models\League;
use App\Models\State;
use App\Models\Team;
use App\Models\Player;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Demo Admin',
            'email' => 'demo.admin@example.com',
            'password' => bcrypt('demoadmin'),
            'is_admin' => true,
        ]);

        $states = State::factory()->allStates()->create();

        $leagues = League::factory()->count(4)->sequence(
            ['name' => 'Little League'],
            ['name' => 'Big Boys'],
            ['name' => 'Peanut League'],
            ['name' => 'Junior League'],
        )->create();

        $teams = Team::factory()->count(5)->recycle($leagues)->sequence(
            ['league_id' => League::factory(), 'name' => 'Tigers', 'mascot' => 'Tigger'],
            ['league_id' => League::factory(), 'name' => 'Lions', 'mascot' => 'Lion'],
            ['league_id' => League::factory(), 'name' => 'Bears', 'mascot' => 'Pooh Bear'],
            ['league_id' => League::factory(), 'name' => 'Wolves', 'mascot' => 'Wolf'],
            ['league_id' => League::factory(), 'name' => 'Eagles', 'mascot' => 'Eagle'],
        )->create();

        Player::factory()->count(14)->recycle($teams)->recycle($states)->create();
    }
}
