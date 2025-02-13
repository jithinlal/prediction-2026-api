<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;
use Illuminate\Http\Request;

class TeamFilter extends APIFilter
{
	protected array $safeParams = [
		'name' => ['eq', 'like'],
		'continent' => ['eq', 'like'],
		'group' => ['eq'],
	];

	protected array $columnMap = [
		'name' => 'name',
		'continent' => 'continent',
		'group' => 'group_id',
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
