<?php

namespace App\Http\Resources\Guild;

use App\Http\Resources\Character\CharacterResource;
use App\Models\Guild\GuildInvitation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GuildInvitationResource extends JsonResource
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
            'character' => CharacterResource::make($this->getResource()->character),
            'guild' => GuildResource::make($this->getResource()->guild),
            'invited_at' => $this->getResource()->created_at,
        ];
    }

    public function getResource(): GuildInvitation
    {
        return $this->resource;
    }
}
