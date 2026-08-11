<?php

namespace Database\Factories;

use App\Models\Player;
use App\Models\State;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Player Factory for the Team Manager application.
 * 
 * @author Scott Greenhagen
 * @version 1.0
 * @package Team Manager
 * @extends Factory<Player>
 */
class PlayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'team_id' => Team::factory(),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'address' => fake()->streetAddress(),
            'city' => fake()->city(),
            'state_id' => State::factory(),
            'zip' => fake()->postcode(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'status' => 'Active', // fake()->randomElement(['Active', 'Inactive']),
        ];
    }
}
