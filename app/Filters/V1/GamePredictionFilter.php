<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;

class GamePredictionFilter extends ApiFilter
{
	protected array $safeParams = [
		'user' => ['eq', 'in'],
		'game' => ['eq', 'in'],
	];

	protected array $columnMap = [
		'user' => 'user_id',
		'game' => 'game_id',
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
