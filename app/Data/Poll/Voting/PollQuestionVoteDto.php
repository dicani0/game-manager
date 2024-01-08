<?php

namespace App\Data\Poll\Voting;

use App\Models\Poll\PollQuestion;
use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class PollQuestionVoteDto extends Data
{
    #[Computed]
    public PollQuestion $question;

    public function __construct(
        #[Required]
        public int $question_id,
        #[DataCollectionOf(PollAnswersVoteDto::class)]
        public DataCollection $answers,
    ) {
        $this->question = PollQuestion::find($question_id);
    }

    public static function rules(ValidationContext $context): array
    {
        return [];
    }
}
