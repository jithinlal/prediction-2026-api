<?php

namespace App\Filters;


use Illuminate\Http\Request;

class ApiFilter
{
	protected array $safeParams = [];

	protected array $columnMap = [];

	protected array $operatorMap = [];

	protected function handleOperator($queryItems, $column, $operator, $value)
	{
		switch ($operator) {
			case 'like':
				$queryItems[] = [$column, $this->operatorMap[$operator], "%$value%"];
				return $queryItems;

			case 'in':
				$values = is_string($value) ? explode(',', $value) : $value;
				$queryItems[] = [$column, $this->operatorMap[$operator], $values];
				return $queryItems;

			default:
				$queryItems[] = [$column, $this->operatorMap[$operator], $value];
				return $queryItems;
		}
	}

	public function transform(Request $request): array
	{
		$eloQuery = [];

		foreach ($this->safeParams as $param => $operators) {
			$query = $request->query($param);

			if (!isset($query)) {
				continue;
			}

			$column = $this->columnMap[$param] ?? $param;

			foreach ($operators as $operator) {
				if (isset($query[$operator])) {
					$value = $query[$operator];

					$eloQuery = $this->handleOperator($eloQuery, $column, $operator, $value);
				}
			}
		}

		return $eloQuery;
	}
}
