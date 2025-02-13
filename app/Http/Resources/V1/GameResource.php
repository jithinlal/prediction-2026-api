<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
					'id' => $this->id,
					'homeId' => $this->home_team_id,
					'homeTeam' => $this->homeTeam->name,
					'awayId' => $this->away_team_id,
					'awayTeam' => $this->awayTeam->name,
					'group' => $this->group->name,
					'gameType' => $this->game_type,
					'date' => $this->date,
					'stadium' => $this->stadium,
					'homeGoals' => $this->home_goals,
					'awayGoals' => $this->away_goals,
					'homePenaltyGoals' => $this->home_penalty_goals,
					'awayPenaltyGoals' => $this->away_penalty_goals,
					'isKnockout' => $this->is_knockout,
				];
    }
}
