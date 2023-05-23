<?php

namespace App\Enums\Trait;

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
}
