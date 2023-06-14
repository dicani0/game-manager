<?php

namespace App\Data\Market;

use App\Models\Market\MarketOffer;
use App\Models\Market\OfferRequest;
use App\Models\User;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class CreateMarketOfferRequestDto extends Data
{
    public function __construct(
        public ?User          $creator,
        public ?MarketOffer   $offer,
        public ?OfferRequest  $offerRequest,
        public ?string        $message,
        #[DataCollectionOf(MarketOfferBuyRequestItemDto::class)]
        public DataCollection $items,
        public ?int           $at_price,
        public ?int           $lat_price,
    )
    {
    }
}
