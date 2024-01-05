<?php

namespace App\Tasks\Poll;

use App\Actions\Poll\CreateVote;
use App\Data\Poll\Voting\PollAnswersVoteDto;
use App\Data\Poll\Voting\PollQuestionVoteDto;
use App\Data\Poll\Voting\PollVotingDto;
use Closure;

class CreateVotesTask
{
    public function __construct(
        protected CreateVote $action
    ) {
    }

    public function handle(PollVotingDto $dto, Closure $next): PollVotingDto
    {
        $dto->questions
            ->each(fn (PollQuestionVoteDto $question) => $question->answers
                ->each(fn (PollAnswersVoteDto $answer) => $this->action->handle($dto->user, $dto->poll, $question->question, $answer->answer)
                ));

        return $next($dto);
    }
}
