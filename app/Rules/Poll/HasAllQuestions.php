<?php

namespace App\Rules\Poll;

use App\Models\Poll\Poll;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class HasAllQuestions implements ValidationRule
{
    public function __construct(public Poll $poll)
    {
    }

    /**
     * Run the validation rule.
     *
     * @param  Closure(string): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $questions = $this->poll->questions->pluck('id');

        $passedQuestions = collect($value)
            ->pluck('question_id');

        $success = $passedQuestions->every(function (int $questionId) use ($questions) {
            return $questions->contains($questionId);
        });

        if (! $success) {
            $fail("The following questions are not part of this poll: {$passedQuestions->diff($questions)->implode(', ')}");
        }
    }
}
