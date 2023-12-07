<?php

namespace App\Data\Market;

use App\Models\Market\MarketOffer;
use App\Models\User;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class CreateMarketOfferDto extends Data
{
    public function __construct(
        #[DataCollectionOf(MarketOfferItemDto::class)]
        public DataCollection $items,
        public ?User $user,
        public ?MarketOffer $offer,
        public bool $promoted = false,
        public ?int $at_price = null,
        public ?int $lat_price = null,
        public ?string $description = null,
    ) {
    }
}
