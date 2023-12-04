<?php

namespace App\Data\Poll;

use App\Casts\CarbonCast;
use App\Enums\PollStatusEnum;
use App\Rules\Poll\CorrectPollableClass;
use DateTime;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\Validation\After;
use Spatie\LaravelData\Attributes\Validation\Before;
use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\RequiredWith;
use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\EnumCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Optional;

class UpdatePollDto extends Data
{
    public function __construct(
        #[Required, StringType, Max(255)]
        public string               $title,
        #[Nullable, StringType, Max(1000)]
        public string|Optional      $description,
        #[Required, Date, Before('end_date')]
        #[WithCast(CarbonCast::class)]
        public DateTime             $start_date,
        #[WithCast(CarbonCast::class)]
        #[Required, Date, After('start_date')]
        public DateTime             $end_date,
        #[Rule(new CorrectPollableClass()), RequiredWith('pollable_id')]
        public string|Optional|null $pollable_type,
        #[RequiredWith('pollable_type')]
        public int|Optional|null    $pollable_id,
        #[DataCollectionOf(CreateQuestionDto::class)]
        #[Min(1), Required]
        public DataCollection       $questions,
        #[WithCast(EnumCast::class)]
        #[In([PollStatusEnum::DRAFT->value, PollStatusEnum::PUBLISHED->value])]
        public PollStatusEnum       $status = PollStatusEnum::DRAFT,
    )
    {
    }
}