<?php

use App\Enums\PollQuestionTypeEnum;
use App\Enums\PollStatusEnum;
use App\Models\Poll\Poll;
use App\Models\Poll\PollQuestion;
use App\Models\Poll\PollQuestionAnswer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PollsTest extends TestCase
{
    private User $user;

    private Poll $poll;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->user->assignRole(Role::firstWhere(['name' => 'admin']));

        $this->poll = $this->createPoll();
    }

    public function test_create_poll(): void
    {
        $res = $this->actingAs($this->user)
            ->post('/polls', [
                'title' => 'Test Poll',
                'description' => 'Test Description',
                'start_date' => now()->toIso8601String(),
                'end_date' => now()->addWeek()->toIso8601String(),
                'status' => PollStatusEnum::DRAFT->value,
                'questions' => [
                    [
                        'question' => 'Test Question',
                        'type' => PollQuestionTypeEnum::SINGLE,
                        'answers' => [
                            [
                                'content' => 'Test Answer 1',
                            ],
                            [
                                'content' => 'Test Answer 2',
                            ],
                        ],
                    ],
                    [
                        'question' => 'Test Question 2',
                        'type' => PollQuestionTypeEnum::MULTIPLE,
                        'answers' => [
                            [
                                'content' => 'Test Answer Multiple 1',
                            ],
                            [
                                'content' => 'Test Answer Multiple 2',
                            ],
                            [
                                'content' => 'Test Answer Multiple 3',
                            ],
                        ],
                    ],
                ],
            ]);

        $res->assertRedirect('/polls');

        $this->assertDatabaseHas('polls', [
            'title' => 'Test Poll',
            'description' => 'Test Description',
            'status' => PollStatusEnum::DRAFT->value,
        ]);

        $this->assertDatabaseHas('poll_questions', [
            'question' => 'Test Question',
            'type' => PollQuestionTypeEnum::SINGLE->value,
        ]);

        $this->assertDatabaseHas('poll_questions', [
            'question' => 'Test Question 2',
            'type' => PollQuestionTypeEnum::MULTIPLE->value,
        ]);

        $this->assertDatabaseHas('poll_question_answers', [
            'content' => 'Test Answer 1',
        ]);

        $this->assertDatabaseHas('poll_question_answers', [
            'content' => 'Test Answer 2',
        ]);

        $this->assertDatabaseHas('poll_question_answers', [
            'content' => 'Test Answer Multiple 1',
        ]);

        $this->assertDatabaseHas('poll_question_answers', [
            'content' => 'Test Answer Multiple 2',
        ]);

        $this->assertDatabaseHas('poll_question_answers', [
            'content' => 'Test Answer Multiple 3',
        ]);
    }

    public function test_create_poll_closed(): void
    {
        $this->actingAs($this->user)
            ->post('/polls', [
                'title' => 'Test Poll',
                'description' => 'Test Description',
                'start_date' => now()->toIso8601String(),
                'end_date' => now()->addWeek()->toIso8601String(),
                'status' => PollStatusEnum::CLOSED->value,
                'questions' => [
                    [
                        'question' => 'Test Question',
                        'type' => PollQuestionTypeEnum::SINGLE,
                        'answers' => [
                            [
                                'content' => 'Test Answer 1',
                            ],
                            [
                                'content' => 'Test Answer 2',
                            ],
                        ],
                    ],
                    [
                        'question' => 'Test Question 2',
                        'type' => PollQuestionTypeEnum::MULTIPLE,
                        'answers' => [
                            [
                                'content' => 'Test Answer Multiple 1',
                            ],
                            [
                                'content' => 'Test Answer Multiple 2',
                            ],
                            [
                                'content' => 'Test Answer Multiple 3',
                            ],
                        ],
                    ],
                ],
            ]);

        $this->assertEquals('The selected status is invalid.', session('errors')->getBag('default')->first());
    }

    public function test_create_poll_insufficient_data(): void
    {
        $this->actingAs($this->user)
            ->post('/polls', [
                'title' => 'Test Poll',
                'description' => 'Test Description',
                'start_date' => now()->toIso8601String(),
                'end_date' => now()->addWeek()->toIso8601String(),
                'status' => PollStatusEnum::DRAFT->value,
                'questions' => [
                    [
                        'question' => 'Test Question',
                        'type' => PollQuestionTypeEnum::SINGLE,
                        'answers' => [
                            [
                                'content' => 'Test Answer 1',
                            ],
                        ],
                    ],
                ],
            ]);

        $this->assertTrue(Str::contains(session('errors')->getBag('default')->first(), 'answers field must have at least 2 items.'));

        $this->actingAs($this->user)
            ->post('/polls', [
                'title' => 'Test Poll',
                'description' => 'Test Description',
                'start_date' => now()->toIso8601String(),
                'end_date' => now()->addWeek()->toIso8601String(),
                'status' => PollStatusEnum::DRAFT->value,
            ]);

        $this->assertEquals('The questions field must be present.', session('errors')->getBag('default')->first());

        $this->actingAs($this->user)
            ->post('/polls', [
                'title' => 'Test Poll',
                'description' => 'Test Description',
                'start_date' => now()->toIso8601String(),
                'end_date' => now()->addWeek()->toIso8601String(),
                'status' => PollStatusEnum::DRAFT->value,
                'questions' => [],
            ]);

        $this->assertEquals('The questions field must have at least 1 items.', session('errors')->getBag('default')->first());
    }

    public function test_create_poll_unauthorized(): void
    {
        $this->actingAs(User::factory()->create())
            ->post('/polls');

        $this->assertEquals('This action is unauthorized.', session('errors')->getBag('default')->first());
    }

    public function test_update_poll(): void
    {
        $res = $this->actingAs($this->user)
            ->put('/polls/'.$this->poll->getKey(), [
                'title' => 'Edited Poll',
                'description' => 'Edited Description',
                'start_date' => now()->toIso8601String(),
                'end_date' => now()->addWeek()->toIso8601String(),
                'status' => PollStatusEnum::DRAFT->value,
                'questions' => [
                    [
                        'id' => $this->poll->questions[0]->getKey(),
                        'question' => 'Edited Question',
                        'type' => PollQuestionTypeEnum::SINGLE,
                        'answers' => [
                            [
                                'id' => $this->poll->questions[0]->answers[0]->getKey(),
                                'content' => 'Test Answer 1',
                            ],
                            [
                                'id' => $this->poll->questions[0]->answers[1]->getKey(),
                                'content' => 'Test Answer 2',
                            ],
                        ],
                    ],
                    [
                        'id' => $this->poll->questions[1]->getKey(),
                        'question' => 'Test Question 2',
                        'type' => PollQuestionTypeEnum::MULTIPLE,
                        'answers' => [
                            [
                                'content' => 'Test Answer Multiple 1',
                            ],
                            [
                                'content' => 'Test Answer Multiple 2',
                            ],
                            [
                                'content' => 'Test Answer Multiple 3',
                            ],
                        ],
                    ],
                ],
            ]);

        $res->assertRedirect('/polls');

        $this->poll->refresh();

        $this->assertDatabaseHas('polls', [
            'id' => $this->poll->getKey(),
            'title' => 'Edited Poll',
            'description' => 'Edited Description',
        ]);

        $this->assertDatabaseHas('poll_questions', [
            'id' => $this->poll->questions[0]->getKey(),
            'question' => 'Edited Question',
            'type' => PollQuestionTypeEnum::SINGLE->value,
        ]);

        $this->assertDatabaseCount('poll_questions', 2);
        $this->assertDatabaseCount('poll_question_answers', 5);

        $this->assertCount(2, $this->poll->questions);
        $this->assertCount(2, $this->poll->questions[0]->answers);
        $this->assertCount(3, $this->poll->questions[1]->answers);
    }

    public function test_update_poll_add_question_and_answers(): void
    {
        $res = $this->actingAs($this->user)
            ->put('/polls/'.$this->poll->getKey(), [
                'title' => 'Edited Poll',
                'description' => 'Edited Description',
                'start_date' => now()->toIso8601String(),
                'end_date' => now()->addWeek()->toIso8601String(),
                'status' => PollStatusEnum::DRAFT->value,
                'questions' => [
                    [
                        'id' => $this->poll->questions[0]->getKey(),
                        'question' => 'Test Question 1',
                        'type' => PollQuestionTypeEnum::SINGLE,
                        'answers' => [
                            [
                                'id' => $this->poll->questions[0]->answers[0]->getKey(),
                                'content' => 'Test Answer 1',
                            ],
                            [
                                'id' => $this->poll->questions[0]->answers[1]->getKey(),
                                'content' => 'Test Answer 2',
                            ],
                            [
                                'content' => 'New Answer For Existing Question',
                            ],
                        ],
                    ],
                    [
                        'id' => $this->poll->questions[1]->getKey(),
                        'question' => 'Test Question 2',
                        'type' => PollQuestionTypeEnum::MULTIPLE,
                        'answers' => [
                            [
                                'content' => 'Test Answer Multiple 1',
                            ],
                            [
                                'content' => 'Test Answer Multiple 2',
                            ],
                            [
                                'content' => 'Test Answer Multiple 3',
                            ],
                        ],
                    ],
                    [
                        'question' => 'New Question',
                        'type' => PollQuestionTypeEnum::SINGLE,
                        'answers' => [
                            [
                                'content' => 'New Answer 1',
                            ],
                            [
                                'content' => 'New Answer 2',
                            ],
                        ],
                    ],
                ],
            ]);

        $res->assertRedirect('/polls');

        $this->poll->refresh();

        $this->assertDatabaseHas('poll_questions', [
            'poll_id' => $this->poll->getKey(),
            'question' => 'New Question',
            'type' => PollQuestionTypeEnum::SINGLE->value,
        ]);

        $this->assertDatabaseHas('poll_question_answers', [
            'poll_question_id' => $this->poll->questions[0]->getKey(),
            'content' => 'New Answer For Existing Question',
        ]);

        $this->assertDatabaseHas('poll_question_answers', [
            'poll_question_id' => $this->poll->questions[2]->getKey(),
            'content' => 'New Answer 1',
        ]);

        $this->assertDatabaseHas('poll_question_answers', [
            'poll_question_id' => $this->poll->questions[2]->getKey(),
            'content' => 'New Answer 2',
        ]);

        $this->assertDatabaseCount('poll_questions', 3);
        $this->assertDatabaseCount('poll_question_answers', 8);

        $this->assertCount(3, $this->poll->questions);
        $this->assertCount(3, $this->poll->questions[0]->answers);
        $this->assertCount(3, $this->poll->questions[1]->answers);
        $this->assertCount(2, $this->poll->questions[2]->answers);
    }

    public function test_update_poll_unauthorized(): void
    {
        $this->actingAs(User::factory()->create())
            ->put('/polls/'.$this->poll->getKey());

        $this->assertEquals('This action is unauthorized.', session('errors')->getBag('default')->first());
    }

    public function test_update_poll_other_user(): void
    {
        $user = User::factory()->create()->assignRole(Role::firstWhere(['name' => 'admin']));
        $this->actingAs($user)
            ->put('/polls/'.$this->poll->getKey());

        $this->assertEquals('This action is unauthorized.', session('errors')->getBag('default')->first());
    }

    private function createPoll(): Poll
    {
        $i = 0;

        return Poll::factory()->has(
            PollQuestion::factory()->count(2)
                ->state(
                    new Sequence(
                        ['question' => 'Test Question 1', 'type' => PollQuestionTypeEnum::SINGLE],
                        ['question' => 'Test Question 2', 'type' => PollQuestionTypeEnum::MULTIPLE],
                    ),
                )->has(
                    PollQuestionAnswer::factory()->count(2)->state(
                        function () use (&$i) {
                            return [
                                'content' => 'Test Answer '.++$i,
                            ];
                        },
                    ),
                    'answers',
                ),
            'questions',
        )->create([
            'creator_id' => $this->user->getKey(),
        ]);
    }
}
