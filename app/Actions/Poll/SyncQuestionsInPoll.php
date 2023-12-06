<?php

namespace App\Actions\Poll;

use App\Data\Poll\UpdateQuestionDto;
use App\Models\Poll\Poll;
use App\Models\Poll\PollQuestion;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Optional;

class SyncQuestionsInPoll
{
    public function handle(Poll $poll, DataCollection $questions): void
    {
        $questionsIds = collect();

        $questions->each(function (UpdateQuestionDto $questionDto) use ($poll, $questionsIds) {
            if ($questionDto->id instanceof Optional) {
                $question = $this->createNewQuestion($poll, $questionDto)->getKey();
                $questionsIds->push($question->getKey());
            } else {
                $question = $this->updateExistingQuestion($poll, $questionDto);

                if ($question !== null) {
                    $questionsIds->push($question->getKey());
                }
            }
            $questionDto->pollQuestion = $question;
        });

        // Delete questions that are not in the list
        $poll->questions()->whereNotIn('id', $questionsIds)->delete();
    }

    private function updateExistingQuestion(Poll $poll, UpdateQuestionDto $dto): ?PollQuestion
    {
        $question = $poll->questions()->find($dto->id);

        if ($question === null) {
            return null;
        }

        $question->update($dto->only(
            'question',
            'type',
            'required',
        )->toArray());

        return $question;
    }

    private function createNewQuestion(Poll $poll, UpdateQuestionDto $dto): PollQuestion
    {
        /** @var PollQuestion $question */
        $question = $poll->questions()->create($dto->only(
            'question',
            'type',
            'required',
        )->toArray());

        return $question;
    }
}
