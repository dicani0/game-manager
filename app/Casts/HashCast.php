<?php

namespace App\Casts;

use Illuminate\Support\Facades\Hash;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\DataProperty;

class HashCast implements Cast
{

    public function cast(DataProperty $property, mixed $value, array $context): string
    {
        return Hash::make($value);
    }
}
