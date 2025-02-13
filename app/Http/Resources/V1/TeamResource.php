<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
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
					'group' => $this->group->name,
					'continent' => $this->continent,
					'image' => $this->image,
					'rank' => $this->rank,
					'worldCups' => $this->world_cups,
					'manager' => $this->manager_name,
					'players' => PlayerResource::collection($this->whenLoaded('players')),
				];
    }
}
