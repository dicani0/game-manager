<?php

namespace App\Data\Poll;

use App\Enums\PollQuestionTypeEnum;
use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\EnumCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;
use Symfony\Contracts\Service\Attribute\Required;

class CreateQuestionDto extends Data
{
    public function __construct(
        #[Required, StringType]
        public string               $title,
        #[StringType]
        public string|Optional      $description,
        #[WithCast(EnumCast::class)]
        public PollQuestionTypeEnum $type,
        #[BooleanType]
        public bool                 $required = true,
    )
    {
    }
}