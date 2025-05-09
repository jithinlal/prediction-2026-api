<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Team;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Player>
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
            'name' => $this->faker->name(),
            'team_id' => Team::factory(),
            'image' => $this->faker->imageUrl(640, 480, 'people'),
            'is_star' => $this->faker->boolean(25), // 25% chance of being a star
            'position' => $this->faker->randomElement(['GK', 'DEF', 'MID', 'FWD']),
            'goals' => $this->faker->numberBetween(0, 30),
            'assists' => $this->faker->numberBetween(0, 30),
            'is_injured' => $this->faker->boolean(10), // 10% chance of being injured
        ];
    }
}
