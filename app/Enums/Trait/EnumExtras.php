<?php

namespace App\Enums\Trait;

trait EnumExtras
{
    public static function getValues(): array
    {
        $values = [];

        foreach (self::cases() as $enum) {
            $values[] = $enum->value;
        }

        return $values;
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
