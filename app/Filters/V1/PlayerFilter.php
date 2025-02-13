<?php

namespace App\Filters\V1;


use App\Filters\ApiFilter;
use Illuminate\Http\Request;

class PlayerFilter extends ApiFilter
{
	protected array $safeParams = [
		'name' => ['eq', 'like'],
		'team' => ['eq'],
		'isStar' => ['eq'],
		'position' => ['eq', 'in'],
		'goals' => ['eq', 'lt', 'gt'],
		'assists' => ['eq', 'lt', 'gt'],
		'isInjured' => ['eq'],
	];

	protected array $columnMap = [
		'name' => 'name',
		'team' => 'team_id',
		'isStar' => 'is_star',
		'position' => 'position',
		'goals' => 'goals',
		'assists' => 'assists',
		'isInjured' => 'is_injured',
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
