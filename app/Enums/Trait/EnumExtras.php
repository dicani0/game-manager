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
}
