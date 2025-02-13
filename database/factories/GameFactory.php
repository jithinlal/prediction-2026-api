<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
        ];
    }

    public function generateMatches(int $groupId): array
    {
        $group = Group::find($groupId);

        $teams = $group->teams->pluck('id')->toArray();

        if (count($teams) !== 4) {
            throw new \InvalidArgumentException("Exactly 4 teams are required in group ID: {$groupId}");
        }

        return [
            [
                'home_team_id' => $teams[0],
                'away_team_id' => $teams[1]
            ],
            [
                'home_team_id' => $teams[2],
                'away_team_id' => $teams[3]
            ],
            [
                'home_team_id' => $teams[0],
                'away_team_id' => $teams[2]
            ],
            [
                'home_team_id' => $teams[1],
                'away_team_id' => $teams[3]
            ],
            [
                'home_team_id' => $teams[0],
                'away_team_id' => $teams[3]
            ],
            [
                'home_team_id' => $teams[1],
                'away_team_id' => $teams[2]
            ]
        ];
    }

    public function generateKnockouts(int $numTeams, array $teams = []): array
    {
        if (count($teams) === 0) {
            $teams = Team::pluck('id')->toArray();
            shuffle($teams);
        }

        $matches = [];
        $knockoutTeams = [];

        for ($i = 0; $i < $numTeams; $i += 2) {
            $matches[] = [
                'home_team_id' => $teams[$i],
                'away_team_id' => $teams[$i + 1]
            ];
            $knockoutTeams[] = $teams[random_int($i, $i + 1)];
        }

        return [
            'matches' => $matches,
            'knockout_teams' => $knockoutTeams,
        ];
    }
}
