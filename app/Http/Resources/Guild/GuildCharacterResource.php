<?php

namespace App\Http\Resources\Guild;

use App\Models\Guild\GuildCharacter;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GuildCharacterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getResource()->id,
            'character_id' => $this->getResource()->character_id,
            'role' => $this->getResource()->role,
            'nickname' => $this->getResource()->character->name,
            'vocation' => $this->getResource()->character->vocation,
        ];
    }

    public function getResource(): GuildCharacter
    {
        return $this->resource;
    }
}
