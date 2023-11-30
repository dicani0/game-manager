<?php


use App\Enums\PollQuestionTypeEnum;
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
                'questions' => [
                    [
                        'title' => 'Test Question',
                        'type' => PollQuestionTypeEnum::SINGLE,
                    ],
                ],
            ]);

        dd($res->json());
    }
}
