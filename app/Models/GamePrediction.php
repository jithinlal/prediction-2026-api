<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GamePrediction extends Model
{
	/** @use HasFactory<\Database\Factories\GamePredictionFactory> */
	use HasFactory;

	protected $fillable = [
		'user_id',
		'game_id',
		'home_goals',
		'away_goals',
		'home_penalty_goals',
		'away_penalty_goals',
		'points',
	];

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	public function game(): BelongsTo
	{
		return $this->belongsTo(Game::class);
	}
}
