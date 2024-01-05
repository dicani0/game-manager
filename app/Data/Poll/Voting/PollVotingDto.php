<?php

namespace App\Data\Poll\Voting;

use App\Models\Poll\Poll;
use App\Models\User;
use App\Rules\Poll\HasAllQuestions;
use Gate;
use Illuminate\Auth\Access\Response;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\FromRouteParameter;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class PollVotingDto extends Data
{
    public ?User $user = null;

    public function __construct(
        #[FromRouteParameter('poll', false)]
        public Poll $poll,
        #[DataCollectionOf(PollQuestionVoteDto::class)]
        public DataCollection $questions,
    ) {
    }

    public static function rules(ValidationContext $context): array
    {
        return [
            'questions' => ['required', 'array', new HasAllQuestions(request()->route('poll'))],
            'questions.*.question_id' => ['required', 'exists:poll_questions,id'],
            'questions.*.answers' => ['required', 'array'],
            'questions.*.answers.*.answer_id' => ['required', 'exists:poll_question_answers,id'],
        ];
    }

    public static function authorize(): Response
    {
        return Gate::authorize('vote', request()->route('poll'));
    }
}
