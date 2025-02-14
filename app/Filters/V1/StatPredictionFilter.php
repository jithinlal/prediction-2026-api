<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;

class StatPredictionFilter extends ApiFilter
{
	protected array $safeParams = [
		'user' => ['eq', 'in'],
		'game' => ['eq', 'in'],
		'player' => ['eq', 'in'],
		'type' => ['eq', 'in'],
	];

	protected array $columnMap = [
		'user' => 'user_id',
		'game' => 'game_id',
		'player' => 'player_id',
		'type' => 'type',
	];

	protected array $operatorMap = [
		'eq' => '=',
		'gt' => '>',
		'gte' => '>=',
		'lt' => '<',
		'lte' => '<=',
		'like' => 'LIKE',
		'in' => 'IN',
	];
}
