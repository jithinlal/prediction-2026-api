<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stat extends Model
{
	/** @use HasFactory<\Database\Factories\StatFactory> */
	use HasFactory;

	public function game(): BelongsTo
	{
		return $this->belongsTo(Game::class);
	}

	public function player(): BelongsTo
	{
		return $this->belongsTo(Player::class);
	}
}
