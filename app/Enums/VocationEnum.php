<?php

namespace App\Enums;

use App\Enums\Trait\EnumExtras;

enum VocationEnum: string
{
    use EnumExtras;
    case KNIGHT = 'knight';
    case PALADIN = 'paladin';
    case SORCERER = 'sorcerer';
    case DRUID = 'druid';
}
