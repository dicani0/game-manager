<?php

namespace App\Http\Resources\Cosmetics;

use App\Models\Cosmetics\Cosmetic;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserCosmeticResource extends JsonResource
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
        ];
    }

    private function getResource(): Cosmetic
    {
        return $this->resource;
    }
}
