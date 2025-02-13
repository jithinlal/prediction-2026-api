<?php

namespace App\Http\Resources\V1;

use App\Models\Team;
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
			'team' => new TeamResource($this->whenLoaded('team')),
			'image' => $this->image,
			'isStar' => $this->is_star,
			'position' => $this->position,
			'goals' => $this->goals,
			'assists' => $this->assists,
			'isInjured' => $this->is_injured,
		];
	}
}
