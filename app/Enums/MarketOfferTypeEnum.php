<?php

namespace App\Enums;

use App\Enums\Trait\EnumExtras;

enum MarketOfferTypeEnum: string
{
    use EnumExtras;

    case MARKET_OFFER = 'Market offer';
    case DIRECT = 'Direct offer';
}
