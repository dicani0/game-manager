<?php

namespace App\Actions\Market\TradeOffers;

use App\Enums\MarketOfferRequestStatusEnum;
use App\Models\Items\Item;
use App\Models\Market\MarketOffer;
use App\Models\Market\TradeOffer;
use Illuminate\Database\Eloquent\Builder;

class CancelOffersWithUnavailableItems
{
    public function handle(TradeOffer $tradeOffer): void
    {
        if ($tradeOffer->offerable instanceof MarketOffer) {
            $item_ids = $tradeOffer->items->pluck('pivot.item_id')->toArray();

            $marketOffer = $tradeOffer->offerable;

            $tradeOffers = $marketOffer->offers()
                ->whereNot('id', $tradeOffer->getKey())
                ->whereNotIn('status', [
                    MarketOfferRequestStatusEnum::REJECTED->value,
                    MarketOfferRequestStatusEnum::ACCEPTED->value,
                ])
                ->whereHas('items', function (Builder $query) use ($item_ids) {
                    $query->whereIn('trade_offer_item.item_id', $item_ids);
                })
                ->get();

            $tradeOffers->each(function (TradeOffer $tradeOffer) use ($marketOffer) {
                $shouldReject = ! $tradeOffer->items->every(function (Item $item) use ($marketOffer) {
                    $offerItem = $marketOffer->items->where('item_id', $item->getKey())->first();

                    return $offerItem && $offerItem->amount >= $item->pivot->amount;
                });

                if ($shouldReject) {
                    $tradeOffer->update([
                        'status' => MarketOfferRequestStatusEnum::REJECTED->value,
                    ]);

                    //TODO Notify user that his offer was rejected
                }
            });
        }
    }
}
