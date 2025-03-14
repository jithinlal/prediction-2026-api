<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Team;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\QueryException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

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
				$countryCode = fake()->unique()->countryCode;
				$name = '';
				$attempt = 1;

				while (true) {
					try {
						$response = Http::get("https://restcountries.com/v3.1/alpha/$countryCode");
						$countryData = $response->json();

						if (!empty($countryData[0]['name'])) {
							$name = $countryData[0]['name']['common'] ?? '';
						} else {
							break;
						}

						logger()->info("Creating team: $name");

						Team::create([
							'name' => $name,
							'group_id' => $group->id,
							'continent' => $countryData[0]['continents'][0] ?? fake()->randomElement($continents),
							'image' => "https://flagsapi.com/$countryCode/flat/64.png",
							'rank' => fake()->unique()->numberBetween(1, 48),
							'world_cups' => fake()->numberBetween(0, 5),
							'manager_name' => fake()->name,
						]);

						break;
					} catch (QueryException $e) {
						$attempt++;

						if ($attempt > 10) {
							throw new Exception("Failed to create team after 10 attempts: $name");
						}
						continue;
					}
				}
			}
		}
	}
}
