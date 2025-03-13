<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stat extends Model
{
	/** @use HasFactory<\Database\Factories\StatFactory> */
	use HasFactory, SoftDeletes;

	protected $fillable = [
		'game_id',
		'player_id',
		'type',
	];

	public function game(): BelongsTo
	{
		return $this->belongsTo(Game::class);
	}

	public function player(): BelongsTo
	{
		return $this->belongsTo(Player::class);
	}
}
