<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Group;
use App\Models\Stadium;
use Carbon\Carbon;
use Database\Factories\GameFactory;
use DateTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    private function getRandomDateTime(Carbon $start, Carbon $end): Carbon
    {
        $randomTimestamp = mt_rand($start->timestamp, $end->timestamp);
        return Carbon::createFromTimestamp($randomTimestamp);
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gameFactory = new GameFactory();
        $groups = Group::all()->pluck('id')->toArray();

        $startDate = Carbon::create(2026, 6, 11, 0, 0, 0);
        $endDate = Carbon::create(2026, 7, 19, 0, 0, 0);

        foreach ($groups as $group) {
            $games = $gameFactory->generateMatches($group);

            foreach ($games as $game) {
                Game::create([
                    'home_team_id' => $game['home_team_id'],
                    'away_team_id' => $game['away_team_id'],
                    'group_id' => $group,
                    'game_type' => 'GROUP',
                    'date' => $this->getRandomDateTime($startDate, $startDate->copy()->addDays(14)),
                    'stadium' => Stadium::stadiums()[random_int(0, 15)],
                ]);
            }
        }

        $round32Start = $startDate->copy()->addDays(15);
        $round32End = $round32Start->copy()->addDays(4);

        $last32 = $gameFactory->generateKnockouts(32);
        foreach ($last32['matches'] as $knockoutGame) {
            Game::create([
                'home_team_id' => $knockoutGame['home_team_id'],
                'away_team_id' => $knockoutGame['away_team_id'],
                'game_type' => 'ROUND OF 32',
                'date' => $this->getRandomDateTime($round32Start, $round32End),
                'stadium' => Stadium::stadiums()[random_int(0, 15)],
            ]);
        }

        $round16Start = $round32End->copy()->addDays(1);
        $round16End = $round16Start->copy()->addDays(4);

        $last16 = $gameFactory->generateKnockouts(16, $last32['knockout_teams']);
        foreach ($last16['matches'] as $knockoutGame) {
            Game::create([
                'home_team_id' => $knockoutGame['home_team_id'],
                'away_team_id' => $knockoutGame['away_team_id'],
                'game_type' => 'ROUND OF 16',
                'date' => $this->getRandomDateTime($round16Start, $round16End),
                'stadium' => Stadium::stadiums()[random_int(0, 15)],
            ]);
        }

        $quarterStart = $round16End->copy()->addDays(1);
        $quarterEnd = $quarterStart->copy()->addDays(2);

        $last8 = $gameFactory->generateKnockouts(8, $last16['knockout_teams']);
        foreach ($last8['matches'] as $knockoutGame) {
            Game::create([
                'home_team_id' => $knockoutGame['home_team_id'],
                'away_team_id' => $knockoutGame['away_team_id'],
                'game_type' => 'QUARTER FINAL',
                'date' => $this->getRandomDateTime($quarterStart, $quarterEnd),
                'stadium' => Stadium::stadiums()[random_int(0, 15)],
            ]);
        }

        $semiStart = $quarterEnd->copy()->addDays(1);
        $semiEnd = $semiStart->copy()->addDays(2);

        $last4 = $gameFactory->generateKnockouts(4, $last8['knockout_teams']);
        foreach ($last4['matches'] as $knockoutGame) {
            Game::create([
                'home_team_id' => $knockoutGame['home_team_id'],
                'away_team_id' => $knockoutGame['away_team_id'],
                'game_type' => 'SEMI FINAL',
                'date' => $this->getRandomDateTime($semiStart, $semiEnd),
                'stadium' => Stadium::stadiums()[random_int(0, 15)],
            ]);
        }

        $thirdPlaceDate = $semiEnd->copy()->addDays(3);

        Game::create([
            'home_team_id' => $last4['matches'][0]['home_team_id'],
            'away_team_id' => $last4['matches'][1]['away_team_id'],
            'game_type' => 'LOOSERS FINAL',
            'date' => $thirdPlaceDate,
            'stadium' => Stadium::stadiums()[random_int(0, 15)],
        ]);

        $finalDate = $thirdPlaceDate->copy()->addDays(1);

        Game::create([
            'home_team_id' => $last4['matches'][0]['away_team_id'],
            'away_team_id' => $last4['matches'][1]['home_team_id'],
            'game_type' => 'FINAL',
            'date' => $finalDate,
            'stadium' => Stadium::stadiums()[random_int(0, 15)],
        ]);
    }
}
