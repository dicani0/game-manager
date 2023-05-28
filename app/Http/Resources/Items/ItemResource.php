<?php

namespace App\Http\Resources\Items;

use App\Models\UserItem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
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
            'item_name' => $this->getResource()->item_name,
            'amount' => $this->getResource()->amount,
            'sold_amount' => $this->getResource()->sold_amount,
            'used_amount' => $this->getResource()->used_amount,
            'available_amount' => $this->getResource()->available_amount,
        ];
    }

    private function getResource(): UserItem
    {
        return $this->resource;
    }
}
