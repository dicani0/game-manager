<?php

namespace App\Actions\Market\TradeOffers;

use App\Models\Items\Item;
use App\Models\Market\TradeOffer;
use Illuminate\Support\Collection;

class TransferSoldItems
{
    public function handle(TradeOffer $tradeOffer): void
    {
        $itemsToUpdate = $this->prepareItemsToUpdate($tradeOffer->items, $tradeOffer->creator->items);

        $tradeOffer->creator->items()->syncWithoutDetaching($itemsToUpdate);
    }

    protected function prepareItemsToUpdate(Collection $items, Collection $creatorItems): array
    {
        return $items->mapWithKeys(function (Item $item) use ($creatorItems) {
            return [$item->getKey() => ['bought_amount' => $this->getBoughtAmount($item, $creatorItems)]];
        })->toArray();
    }

    protected function getBoughtAmount(Item $item, Collection $creatorItems): int
    {
        $targetItem = $creatorItems->where('pivot.item_id', $item->getKey())->first();

        return $targetItem ? $targetItem->pivot->bought_amount + $item->pivot->amount : $item->pivot->amount;
    }
}
