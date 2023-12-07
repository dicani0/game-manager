<?php

namespace App\Casts;

use Carbon\Carbon;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Casts\Uncastable;
use Spatie\LaravelData\Support\DataProperty;
use Throwable;

class CarbonCast implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $context): Carbon|Uncastable
    {
        try {
            return Carbon::make($value);
        } catch (Throwable $th) {
            return Uncastable::create();
        }
    }
}
