<?php

namespace App\Enums\Trait;

use Illuminate\Support\Str;

trait EnumExtras
{
    public static function getValues(): array
    {
        return array_values(self::cases());
    }

    public static function getKeys(): array
    {
        return array_keys(self::cases());
    }

    public static function getKeysAndValues(): array
    {
        return self::cases();
    }

    public static function getValuesToUpperCase(): array
    {
        return array_map(fn ($value) => Str::ucfirst($value->value), self::getValues());
    }
}
