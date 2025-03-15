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
			'homeTeam' => new TeamResource($this->whenLoaded('homeTeam')),
			'awayTeam' => new TeamResource($this->whenLoaded('awayTeam')),
			'group' => $this->group?->name,
			'gameType' => $this->game_type,
			'date' => $this->date,
			'stadium' => $this->stadium,
			'stadiumUrl' => $this->stadium_url,
			'homeGoals' => $this->home_goals,
			'awayGoals' => $this->away_goals,
			'homePenaltyGoals' => $this->home_penalty_goals,
			'awayPenaltyGoals' => $this->away_penalty_goals,
			'isKnockout' => $this->is_knockout,
			'prediction' => $this->when($this->whenLoaded('prediction'), function () {
				return new GamePredictionResource($this->prediction);
			}),
			'statPredictions' => $this->when($this->whenLoaded('statPredictions'), function () {
				return new StatPredictionCollection($this->statPredictions);
			}),
		];
	}
}
