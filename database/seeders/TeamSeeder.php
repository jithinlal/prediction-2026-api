<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $continents = ['Europe', 'South America', 'North America', 'Africa', 'Asia', 'Oceania'];

        $groups = Group::all();

        foreach ($groups as $group) {
            for ($i = 0; $i < 4; $i++) {
                Team::create([
                    'name' => fake()->unique()->country,
                    'group_id' => $group->id,
                    'continent' => fake()->randomElement($continents),
                    'image' => fake()->imageUrl(640, 480, 'sports'),
                    'rank' => fake()->unique()->numberBetween(1, 48),
                    'world_cups' => fake()->numberBetween(0, 5),
                    'manager_name' => fake()->name,
                ]);
            }
        }
    }
}
