<?php

namespace App\Http\Resources\Items;

use App\Models\Items\Item;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getResource()->getKey(),
            'item_name' => $this->getResource()->name,
            'amount' => $this->getResource()->pivot->amount,
            'sold_amount' => $this->getResource()->pivot->sold_amount,
            'used_amount' => $this->getResource()->pivot->used_amount,
            'available_amount' => $this->getResource()->pivot->available_amount,
            'reserved_amount' => $this->getResource()->pivot->reserved_amount,
            'bought_amount' => $this->getResource()->pivot->bought_amount,
            'tier' => $this->getResource()->tier,
            'power' => $this->getResource()->power,
            'attributes' => $this->getResource()->attributes,
        ];
    }

    private function getResource(): Item
    {
        return $this->resource;
    }
}
