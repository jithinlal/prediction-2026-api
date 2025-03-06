<?php

namespace App\Models;

use App\Enums\StatTypeEnum;
use Illuminate\Database\Eloquent\Model;

class StatType extends Model
{
	const types = [
		StatTypeEnum::GOAL->value => 2,
		StatTypeEnum::ASSIST->value => 2,
		StatTypeEnum::OWN_GOAL->value => 5,
		StatTypeEnum::HAT_TRICK->value => 5,
		StatTypeEnum::RED_CARD->value => 3,
		StatTypeEnum::YELLOW_CARD->value => 2,
		StatTypeEnum::CLEAN_SHEET->value => 2,
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
