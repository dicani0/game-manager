<?php

namespace App\Enums;

use App\Enums\Trait\EnumExtras;

enum ItemTierEnum: string
{
    use EnumExtras;

    case TIER_1 = 'tier_1';
    case TIER_2 = 'tier_2';
    case TIER_3 = 'tier_3';
    case TIER_4 = 'tier_4';
    case TIER_5 = 'tier_5';
    case TIER_6 = 'tier_6';

}
