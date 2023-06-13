<?php

namespace App\Data\Market;

use App\Models\Market\MarketOffer;
use App\Models\User;
use Spatie\LaravelData\DataCollection;

class CreateMarketOfferRequestDto
{
    public function __construct(
        public ?User          $creator,
        public ?MarketOffer   $offer,
        public ?string        $message,
        #DataCollectionOf(MarketOfferItemDto::class)
        public DataCollection $items,
        public ?int           $at_price,
        public ?int           $lat_price,
    )
    {
    }
}
