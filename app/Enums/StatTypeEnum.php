<?php

namespace App\Enums;

enum StatTypeEnum: string
{
	case GOAL = 'goal';
	case ASSIST = 'assist';
	case YELLOW_CARD = 'yellow_card';
	case RED_CARD = 'red_card';
	case OWN_GOAL = 'own_goal';
	case CLEAN_SHEET = 'clean_sheet';
	case HAT_TRICK = 'hat_trick';
}
