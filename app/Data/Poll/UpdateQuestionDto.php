<?php

namespace App\Data\Poll;

use App\Enums\PollQuestionTypeEnum;
use App\Models\Poll\PollQuestion;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\EnumCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Optional;
use Symfony\Contracts\Service\Attribute\Required;

class UpdateQuestionDto extends Data
{
    public function __construct(
        #[Exists('poll_questions', 'id')]
        public int|Optional $id,
        #[Required, StringType]
        public string $question,
        #[WithCast(EnumCast::class)]
        public PollQuestionTypeEnum $type,
        #[DataCollectionOf(UpdateAnswerDto::class)]
        #[Required, Min(2)]
        public DataCollection $answers,
        #[BooleanType]
        public bool $required = true,
        public ?PollQuestion $pollQuestion = null,
    ) {
    }
}
