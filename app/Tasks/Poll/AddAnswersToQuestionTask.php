<?php

namespace App\Tasks\Poll;

use App\Actions\Poll\AddAnswersToQuestion;
use App\Data\Poll\CreatePollDto;
use App\Data\Poll\CreateQuestionDto;
use Closure;

class AddAnswersToQuestionTask
{
    public function __construct(
        protected AddAnswersToQuestion $action
    )
    {
    }

    public function handle(CreatePollDto $dto, Closure $next): CreatePollDto
    {
        $dto->questions->each(
            fn(CreateQuestionDto $question) => $this->action->handle($question->pollQuestion, $question->answers)
        );

        return $next($dto);
    }
}
