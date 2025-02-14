<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GamePredictionResource extends JsonResource
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
					'user' => new UserResource($this->whenLoaded('user')),
					'game' => new GameResource($this->whenLoaded('game')),
					'homeGoals' => $this->home_goals,
					'awayGoals' => $this->away_goals,
					'homePenaltyGoals' => $this->home_penalty_goals,
					'awayPenaltyGoals' => $this->away_penalty_goals,
					'points' => $this->points,
				];
    }
}
