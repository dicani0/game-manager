<?php

namespace App\Enums;

use App\Enums\Trait\EnumExtras;

enum OfferTypeEnum: string
{
    use EnumExtras;
    case BUY = 'buy';
    case SELL = 'sell';
}
