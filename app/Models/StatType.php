<?php

namespace App\Models;

use App\Enums\StatTypeEnum;
use Illuminate\Database\Eloquent\Model;

class StatType extends Model
{
	const types = [
		StatTypeEnum::YELLOW_CARD->value => 1,
		StatTypeEnum::CLEAN_SHEET->value => 2,
		StatTypeEnum::GOAL->value => 3,
		StatTypeEnum::RED_CARD->value => 5,
	];

		public static function getPoint(string $type): int
		{
				return self::types[$type];
		}

		public static function getTypes(): array
		{
			$types = [];

			foreach (self::types as $type => $points) {
				$types[] = [
					'type' => $type,
					'points' => $points,
				];
			}

			return $types;
		}
}
