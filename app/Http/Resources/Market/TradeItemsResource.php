<?php

namespace App\Http\Resources\Market;

use App\Models\Items\Item;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TradeItemsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->getResource()->name,
            'amount' => $this->getResource()->pivot->amount,
        ];
    }

    public function getResource(): Item
    {
        return $this->resource;
    }
}
