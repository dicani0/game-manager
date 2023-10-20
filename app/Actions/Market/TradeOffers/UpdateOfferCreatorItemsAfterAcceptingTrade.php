<?php

namespace App\Actions\Market\TradeOffers;

use App\Enums\OfferTypeEnum;
use App\Models\Items\Item;
use App\Models\Items\UserItem;
use App\Models\Market\TradeOffer;
use Illuminate\Support\Facades\Auth;

class UpdateOfferCreatorItemsAfterAcceptingTrade
{
    public function handle(TradeOffer $tradeOffer): void
    {
        $tradeOffer->items->each(function (Item $item) use ($tradeOffer) {
            logger('Item', [
                'item_id' => $item->getKey(),
                'trade_offer_id' => $tradeOffer->getKey(),
                'type' => $tradeOffer->type,
            ]);

            $query = UserItem::query()
                ->where('user_id', Auth::id())
                ->where('item_id', $item->getKey());

            if ($tradeOffer->type === OfferTypeEnum::BUY) {
                logger('Reserved amount', [
                    'reserved_amount' => $item->pivot->amount,
                    'sold_amount' => $item->pivot->amount,
                ]);

                $query->decrement('reserved_amount', $item->pivot->amount);

                logger('Sold amount', [
                    'reserved_amount' => $item->pivot->amount,
                    'sold_amount' => $item->pivot->amount,
                ]);
                
                $query->increment('sold_amount', $item->pivot->amount);
            } elseif ($tradeOffer->type === OfferTypeEnum::SELL) {
                $query->decrement('amount', $item->pivot->amount);
            }
        });
    }
}
