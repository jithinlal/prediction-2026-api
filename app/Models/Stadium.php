<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stadium extends Model
{
	public static function stadiums(): array
	{
		return [
			'Atlanta Stadium',
			'BC Place Vancouver',
			'Boston Stadium',
			'Dallas Stadium',
			'Estadio Azteca Mexico City',
			'Estadio Guadalajara',
			'Estadio Monterrey',
			'Houston Stadium',
			'Kansas City Stadium',
			'Los Angeles Stadium',
			'Miami Stadium',
			'New York New Jersey Stadium',
			'Philadelphia Stadium',
			'San Francisco Bay Area Stadium',
			'Seattle Stadium',
			'Toronto Stadium',
		];
	}
}
