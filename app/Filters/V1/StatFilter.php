<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;

class StatFilter extends ApiFilter
{
	protected array $safeParams = [
		'game' => ['eq', 'in'],
		'player' => ['eq', 'in'],
		'type' => ['eq'],
	];

	protected array $columnMap = [
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
