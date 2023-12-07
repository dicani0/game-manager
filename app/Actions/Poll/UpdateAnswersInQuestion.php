<?php

namespace App\Actions\Poll;

use App\Data\Poll\UpdateAnswerDto;
use App\Models\Poll\PollQuestion;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Optional;

class UpdateAnswersInQuestion
{
    public function handle(PollQuestion $question, DataCollection $answers): void
    {
        // Collect all the ids from dto
        $idsInDto = $answers->filter(function (UpdateAnswerDto $answerDto) {
            return ! $answerDto->id instanceof Optional;
        })->toCollection()->pluck('id');

        // Delete answers not in dto
        $question->answers()->whereNotIn('id', $idsInDto)->delete();

        $answers->each(function (UpdateAnswerDto $answerDto) use ($question) {
            if (! $answerDto->id instanceof Optional) {
                $answer = $question->answers()->find($answerDto->id);

                if ($answer === null) {
                    $question->answers()->create([
                        'content' => $answerDto->content,
                    ]);
                } else {
                    $answer->update([
                        'content' => $answerDto->content,
                    ]);
                }

            } else {
                $question->answers()->create([
                    'content' => $answerDto->content,
                ]);
            }
        });
    }
}
