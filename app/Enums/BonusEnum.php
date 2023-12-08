<?php

namespace App\Enums;

use App\Enums\Trait\EnumExtras;
use Exception;

enum BonusEnum: string
{
    use EnumExtras;

    case ATTACK_POWER = 'Attack Power';
    case HP_MP = 'HP/MP%';
    case RESISTANCE = 'Resistance';
    case ESSENCE_FIND = 'Essence Find';
    case MINING = 'Mining';
    case SMITHING = 'Smithing';
    case FISHING = 'Fishing';
    case WOODCUTTING = 'Woodcutting';
    case WOODWORKING = 'Woodworking';
    case SKINNING = 'Skinning';
    case TANNING = 'Tanning';
    case FARMING = 'Farming';
    case JEWELCRAFTING = 'Jewelcrafting';
    case ALCHEMY = 'Alchemy';
    case COOKING = 'Cooking';

    /**
     * @throws Exception
     */
    public function possibleValues(): array
    {
        return match ($this) {
            self::ATTACK_POWER => [2, 4, 8, 10, 12, 15, 18, 25, 30],
            self::HP_MP => [0.2, 0.5, 1, 1.5, 1.75, 2.5, 3],
            self::RESISTANCE => [1],
            self::ESSENCE_FIND => [2, 3, 4, 10],
            self::MINING,
            self::SMITHING,
            self::FISHING,
            self::WOODCUTTING,
            self::WOODWORKING,
            self::SKINNING,
            self::TANNING,
            self::FARMING,
            self::JEWELCRAFTING,
            self::ALCHEMY,
            self::COOKING => [2],
        };
    }
}
