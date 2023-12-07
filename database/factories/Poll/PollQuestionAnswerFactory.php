<?php

namespace Database\Factories\Poll;

use App\Models\Poll\PollQuestionAnswer;
use Illuminate\Database\Eloquent\Factories\Factory;

class PollQuestionAnswerFactory extends Factory
{
    protected $model = PollQuestionAnswer::class;

    public function definition(): array
    {
        return [
            'content' => $this->faker->sentence,
        ];
    }
}
