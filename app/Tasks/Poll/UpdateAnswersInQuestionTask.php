<?php

namespace App\Tasks\Poll;

use App\Actions\Poll\UpdateAnswersInQuestion;
use App\Data\Poll\UpdatePollDto;
use App\Data\Poll\UpdateQuestionDto;
use Closure;

class UpdateAnswersInQuestionTask
{
    public function __construct(
        protected UpdateAnswersInQuestion $action
    )
    {
    }

    public function handle(UpdatePollDto $dto, Closure $next): UpdatePollDto
    {
        $dto->questions->each(
            fn(UpdateQuestionDto $question) => $this->action->handle($question->pollQuestion, $question->answers)
        );

        return $next($dto);
    }
}
