<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
	use HasFactory, SoftDeletes;

	public function teams(): HasMany
	{
		return $this->hasMany(Team::class);
	}

	public function games(): HasMany
	{
		return $this->hasMany(Game::class);
	}
}
