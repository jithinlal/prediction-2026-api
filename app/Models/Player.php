<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Player extends Model
{
	use SoftDeletes;
	
	public function team(): BelongsTo
	{
		return $this->belongsTo(Team::class);
	}

	public function stats(): HasMany
	{
		return $this->hasMany(Stat::class);
	}

	public function statPredictions(): HasMany
	{
		return $this->hasMany(StatPrediction::class);
	}
}
