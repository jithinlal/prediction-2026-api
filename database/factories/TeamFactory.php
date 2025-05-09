<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Group;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->country,
            'group_id' => Group::factory(),
            'continent' => $this->faker->randomElement(['Asia', 'Africa', 'North America', 'South America', 'Europe', 'Oceania']),
            'image' => $this->faker->imageUrl(),
            'rank' => $this->faker->numberBetween(1, 200),
            'world_cups' => $this->faker->numberBetween(0, 5),
            'manager_name' => $this->faker->name(),
            'is_eliminated' => $this->faker->boolean(),
        ];
    }
}
