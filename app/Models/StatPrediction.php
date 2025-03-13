<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class StatPrediction extends Model
{
	/** @use HasFactory<\Database\Factories\StatPredictionFactory> */
	use HasFactory, SoftDeletes;

	protected $fillable = [
		'user_id',
		'game_id',
		'player_id',
		'type',
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

	public function player(): BelongsTo
	{
		return $this->belongsTo(Player::class);
	}
}
