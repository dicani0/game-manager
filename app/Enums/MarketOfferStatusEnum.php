<?php

namespace App\Enums;

use App\Enums\Trait\EnumExtras;

enum MarketOfferStatusEnum: string
{
    use EnumExtras;
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case CANCELED = 'canceled';
    case FINISHED = 'finished';
    case EXPIRED = 'expired';
}
