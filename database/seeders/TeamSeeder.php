<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Team;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\QueryException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class TeamSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$continents = ['Europe', 'South America', 'North America', 'Africa', 'Asia', 'Oceania'];
		$jsonContent = base_path('database/seeders/countries.json');
		$countries = json_decode(File::get($jsonContent), true);

		$groups = Group::all();

		$availableRanks = range(1, 100);
		shuffle($availableRanks);
		$usedCountries = [];
		$count = 0;

		foreach ($groups as $group) {
			for ($i = 0; $i < 4; $i++) {
				if ($count === 48) {
					return;
				}

				while (true) {
					try {
						$country = fake()->randomElement($countries);

						$countryName = $country['name']['common'] ?? '';
						$rank = $availableRanks[$count];

						if (in_array($countryName, $usedCountries)) {
							continue;
						}

						logger()->info("Creating team: $countryName");

						Team::create([
							'name' => $countryName,
							'group_id' => $group->id,
							'continent' => $country['continents'][0] ?? fake()->randomElement($continents),
							'image' => $country['flags']['png'] ?? '',
							'rank' => $rank,
							'world_cups' => fake()->numberBetween(0, 5),
							'manager_name' => fake()->name,
						]);

						$usedCountries[] = $countryName;
						$count++;

						break;
					} catch (QueryException $e) {
						logger()->error("Failed to create team: $countryName - " . $e->getMessage());
						throw new Exception("Failed to create team: $countryName - " . $e->getMessage());
					}
				}
			}
		}
	}
}
