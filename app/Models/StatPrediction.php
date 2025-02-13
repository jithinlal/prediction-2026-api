<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StatPrediction extends Model
{
	/** @use HasFactory<\Database\Factories\StatPredictionFactory> */
	use HasFactory;

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
