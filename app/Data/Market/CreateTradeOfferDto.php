<?php

namespace App\Data\Market;

use App\Models\Market\MarketOffer;
use App\Models\Market\TradeOffer;
use App\Models\User;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class CreateTradeOfferDto extends Data
{
    public function __construct(
        public ?User $creator,
        public MarketOffer|User $target,
        public ?TradeOffer $tradeOffer,
        public ?string $message,
        #[DataCollectionOf(TradeOfferItemDto::class)]
        public DataCollection $items,
        public ?int $at_price,
        public ?int $lat_price,
    ) {
    }
}
