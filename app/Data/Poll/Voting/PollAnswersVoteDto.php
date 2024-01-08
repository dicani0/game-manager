<?php

namespace App\Data\Poll\Voting;

use App\Models\Poll\PollQuestionAnswer;
use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Data;

class PollAnswersVoteDto extends Data
{
    #[Computed]
    public PollQuestionAnswer $answer;

    public function __construct(
        public int $answer_id
    ) {
        $this->answer = PollQuestionAnswer::find($answer_id);
    }
}
