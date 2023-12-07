<?php

namespace App\Traits;

use App\Models\Market\TradeOffer;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Offerable
{
    public function offers(): MorphMany
    {
        return $this->morphMany(TradeOffer::class, 'offerable');
    }
}
