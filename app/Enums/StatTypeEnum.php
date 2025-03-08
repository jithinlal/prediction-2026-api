<?php

namespace App\Enums;

enum StatTypeEnum: string
{
	case GOAL = 'goal';
	case YELLOW_CARD = 'yellow_card';
	case RED_CARD = 'red_card';
	case CLEAN_SHEET = 'clean_sheet';
}
