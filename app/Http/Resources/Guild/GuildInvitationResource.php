<?php

namespace App\Http\Resources\Guild;

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
            'character' => $this->getResource()->character(),
        ];
    }

    public function getResource(): GuildInvitation
    {
        return $this->resource;
    }
}
