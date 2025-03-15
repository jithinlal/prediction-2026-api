<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Game extends Model
{
	/** @use HasFactory<\Database\Factories\GameFactory> */
	use HasFactory, SoftDeletes;

	public function homeTeam(): BelongsTo
	{
		return $this->belongsTo(Team::class, 'home_team_id');

	}

	public function awayTeam(): BelongsTo
	{
		return $this->belongsTo(Team::class, 'away_team_id');
	}

	public function group(): BelongsTo
	{
		return $this->belongsTo(Group::class);
	}

	public function stats(): HasMany
	{
		return $this->hasMany(Stat::class);
	}

	public function prediction(): HasOne
	{
		return $this->hasOne(GamePrediction::class);
	}

	public function statPredictions(): HasMany
	{
		return $this->hasMany(StatPrediction::class);
	}
}
