<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
	protected $fillable = [
		'name',
		'group_id',
		'continent',
		'image',
		'rank',
		'world_cups',
		'manager_name'
	];

	public function group(): BelongsTo
	{
		return $this->belongsTo(Group::class);
	}

	public function players(): HasMany
	{
		return $this->hasMany(Player::class);
	}

	public function homeGames(): HasMany
	{
		return $this->hasMany(Game::class, 'home_team_id');
	}

	public function awayGames(): HasMany
	{
		return $this->hasMany(Game::class, 'away_team_id');
	}

	public function allGames()
	{
		return $this->homeGames->merge($this->awayGames);
	}
}
