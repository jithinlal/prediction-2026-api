<?php

namespace Database\Seeders;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlayerSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 */
	public function run(): void {
		$noOfGoalKeeper = 3;
		$noOfDefender = 6;
		$noOfMidfielder = 9;
		$noOfForward = 5;

		$playerCounts = [
			['count' => $noOfGoalKeeper, 'pos' => 'GK'],
			['count' => $noOfDefender, 'pos' => 'DEF'],
			['count' => $noOfMidfielder, 'pos' => 'MID'],
			['count' => $noOfForward, 'pos' => 'FWD']
		];
		
		$teams = Team::all();

		foreach ($teams as $team) {
			$starCount = 0;
			foreach ($playerCounts as $playerCount) {
				for ($i = 0; $i < $playerCount['count']; $i++) {
					$name = fake()->firstName('male') . ' ' . fake()->lastName('male');
					Player::create([
						'name' => $name,
						'team_id' => $team->id,
						'image' => 'https://api.dicebear.com/9.x/micah/svg?seed=' . $name,
						'is_star' => $playerCount['pos'] === 'FWD' && $starCount++ <= 3,
						'position' => $playerCount['pos'],
						'goals' => $playerCount['pos'] !== 'GK' ? fake()->numberBetween(0, 100) : 0,
						'assists' => $playerCount['pos'] !== 'GK' ? fake()->numberBetween(0, 100) : 0,
					]);
				}
			}
		}
	}
}
