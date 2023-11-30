<?php

namespace App\Data\Poll;

use DateTime;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\Validation\After;
use Spatie\LaravelData\Attributes\Validation\Before;
use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Optional;
use Symfony\Contracts\Service\Attribute\Required;

class CreatePollDto extends Data
{
    public function __construct(
        #[Required, StringType, Max(255)]
        public string               $title,
        #[Nullable, StringType, Max(1000)]
        public string|Optional      $description,
        #[Required, Date, Before('end_date')]
        #[WithCast(DateTimeInterfaceCast::class)]
        public DateTime             $start_date,
        #[WithCast(DateTimeInterfaceCast::class)]
        #[Required, Date, After('start_date')]
        public DateTime             $end_date,
        public string|Optional|null $pollable_type,
        public int|Optional|null    $pollable_id,
        #[DataCollectionOf(CreateQuestionDto::class)]
        #[Min(1), Required]
        public DataCollection       $questions,
    )
    {
    }
}