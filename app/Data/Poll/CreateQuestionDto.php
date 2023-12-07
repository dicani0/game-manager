<?php

namespace App\Data\Poll;

use App\Enums\PollQuestionTypeEnum;
use App\Models\Poll\PollQuestion;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\EnumCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Symfony\Contracts\Service\Attribute\Required;

class CreateQuestionDto extends Data
{
    public function __construct(
        #[Required, StringType]
        public string               $question,
        #[WithCast(EnumCast::class)]
        public PollQuestionTypeEnum $type,
        #[DataCollectionOf(CreateAnswerDto::class)]
        #[Required, Min(2)]
        public DataCollection       $answers,
        #[BooleanType]
        public bool                 $required = true,
        public ?PollQuestion        $pollQuestion = null,
    )
    {
    }
}