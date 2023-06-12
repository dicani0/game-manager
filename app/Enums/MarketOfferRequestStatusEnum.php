<?php

namespace App\Enums;

use App\Enums\Trait\EnumExtras;

enum MarketOfferRequestStatusEnum: string
{
    use EnumExtras;
    case PENDING = 'pending';
    case REJECTED = 'rejected';
    case ACCEPTED = 'accepted';
}
