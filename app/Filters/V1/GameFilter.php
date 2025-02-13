<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;

class GameFilter extends ApiFilter
{
	protected array $safeParams = [
		'home' => ['eq', 'in'],
		'away' => ['eq', 'in'],
		'group' => ['eq', 'in'],
		'type' => ['eq', 'in'],
		'date' => ['eq', 'in'],
		'stadium' => ['eq', 'like', 'in'],
	];

	protected array $columnMap = [
		'home' => 'home_team_id',
		'away' => 'away_team_id',
		'group' => 'group_id',
		'type' => 'game_type',
		'date' => 'date',
		'stadium' => 'stadium',
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
