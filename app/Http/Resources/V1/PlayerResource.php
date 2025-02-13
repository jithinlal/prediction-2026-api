<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlayerResource extends JsonResource
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
					'name' => $this->name,
					'teamId' => $this->team_id,
					'team' => $this->team->name,
					'image' => $this->image,
					'isStar' => $this->is_star,
					'position' => $this->position,
					'goals' => $this->goals,
					'assists' => $this->assists,
					'isInjured' => $this->is_injured,
				];
    }
}
