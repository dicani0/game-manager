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

        dd($res->json());
    }
}
