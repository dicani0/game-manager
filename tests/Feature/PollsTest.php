<?php


use App\Enums\PollQuestionTypeEnum;
use App\Enums\PollStatusEnum;
use App\Models\User;
use Tests\TestCase;

class PollsTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
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
        $res = $this->actingAs($this->user)
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
                        ],
                    ],
                ],
            ]);

        $this->assertTrue(Str::contains(session('errors')->getBag('default')->first(), 'answers field must have at least 2 items.'));

        $res = $this->actingAs($this->user)
            ->post('/polls', [
                'title' => 'Test Poll',
                'description' => 'Test Description',
                'start_date' => now()->toIso8601String(),
                'end_date' => now()->addWeek()->toIso8601String(),
                'status' => PollStatusEnum::DRAFT->value,
            ]);

        $this->assertEquals('The questions field must be present.', session('errors')->getBag('default')->first());

        $res = $this->actingAs($this->user)
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
}
