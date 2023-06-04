<?php

namespace App\Data\Market;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class CreateMarketOfferDto extends Data
{
    public function __construct(
        #[DataCollectionOf(MarketOfferItemDto::class)]
        public DataCollection $items,
        public string         $type,
    )
    {
    }
}
