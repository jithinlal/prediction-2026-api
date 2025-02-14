<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StatPredictionResource extends JsonResource
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
					'player' => new PlayerResource($this->whenLoaded('player')),
					'type' => $this->type,
					'points' => $this->points,
				];
    }
}
