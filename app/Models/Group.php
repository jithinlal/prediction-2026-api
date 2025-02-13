<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
	public function teams(): HasMany
	{
		return $this->hasMany(Team::class);
	}

	public function games(): HasMany
	{
		return $this->hasMany(Game::class);
	}
}
