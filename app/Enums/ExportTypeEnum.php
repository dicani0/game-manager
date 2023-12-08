<?php

namespace App\Enums;

use App\Enums\Trait\EnumExtras;

enum ExportTypeEnum: string
{
    use EnumExtras;

    case SELLABLE = 'sellable';
    case STANDARD = 'standard';
}
