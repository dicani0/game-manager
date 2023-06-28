<?php

namespace App\Data\Market;

use Spatie\LaravelData\Data;

class MarketOfferItemDto extends Data
{
    public int $item_id;
    public int $amount;
}
