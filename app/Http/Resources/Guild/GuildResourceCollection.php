<?php

namespace App\Http\Resources\Guild;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

class GuildResourceCollection extends ResourceCollection
{
    public function __construct(Collection $resource)
    {
        parent::__construct($resource);
        $this->collection = $this->collection->map(function (GuildResource $item) {
            return $item->withoutCharacters();
        });
    }
}
