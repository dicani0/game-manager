<?php

namespace App\Data\Items;

use App\Enums\ExportTypeEnum;
use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Attributes\FromRouteParameter;
use Spatie\LaravelData\Attributes\Validation\Enum;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\EnumCast;
use Spatie\LaravelData\Data;

class ExportItemsDto extends Data
{
    #[Computed]
    public string $filename;

    public function __construct(
        #[
            WithCast(EnumCast::class),
            FromRouteParameter('type'),
            Enum(ExportTypeEnum::class)
        ]
        public ExportTypeEnum $type = ExportTypeEnum::STANDARD,
    ) {
        $this->filename = $this->type->value.'_items.xlsx';
    }
}
