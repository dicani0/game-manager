<?php

use App\Enums\PollQuestionTypeEnum;
use App\Enums\PollStatusEnum;
use App\Enums\VocationEnum;
use App\Models\Guild\Guild;
use App\Models\Guild\GuildCharacter;
use App\Models\Poll\Poll;
use App\Models\Poll\PollQuestion;
use App\Models\Poll\PollQuestionAnswer;
use App\Models\Poll\Vote;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class VotingTest extends TestCase
{
    private User $user;

    private Poll $globalPoll;

    private Poll $guildPoll;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->user->assignRole(Role::firstWhere(['name' => 'admin']));

        $this->globalPoll = $this->createPoll();
        $this->guildPoll = $this->createPoll(Guild::factory()->create());
    }

    public function test_vote_in_global_poll(): void
    {
        $response = $this->actingAs($this->user)
            ->post("polls/{$this->globalPoll->getKey()}/vote", [
                'questions' => [
                    [
                        'question_id' => $this->globalPoll->questions->first()->getKey(),
                        'answers' => [
                            [
                                'answer_id' => $this->globalPoll->questions->first()->answers->first()->getKey(),
                            ],
                        ],
                    ],
                    [
                        'question_id' => $this->globalPoll->questions->last()->getKey(),
                        'answers' => [
                            [
                                'answer_id' => $this->globalPoll->questions->last()->answers->first()->getKey(),
                            ],
                        ],
                    ],
                ],
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Your votes have been submitted.');

        $this->assertDatabaseHas('votes', [
            'user_id' => $this->user->getKey(),
            'poll_question_id' => $this->globalPoll->questions->first()->getKey(),
            'poll_question_answer_id' => $this->globalPoll->questions->first()->answers->first()->getKey(),
        ]);

        $this->assertDatabaseHas('votes', [
            'user_id' => $this->user->getKey(),
            'poll_question_id' => $this->globalPoll->questions->last()->getKey(),
            'poll_question_answer_id' => $this->globalPoll->questions->last()->answers->first()->getKey(),
        ]);
    }

    public function test_vote_in_global_poll_not_started(): void
    {
        $this->globalPoll = $this->createPoll(null, PollStatusEnum::DRAFT);

        $response = $this->actingAs($this->user)
            ->post("polls/{$this->globalPoll->getKey()}/vote", [
                'questions' => [
                    [
                        'question_id' => $this->globalPoll->questions->first()->getKey(),
                        'answers' => [
                            [
                                'answer_id' => $this->globalPoll->questions->first()->answers->first()->getKey(),
                            ],
                        ],
                    ],
                    [
                        'question_id' => $this->globalPoll->questions->last()->getKey(),
                        'answers' => [
                            [
                                'answer_id' => $this->globalPoll->questions->last()->answers->first()->getKey(),
                            ],
                        ],
                    ],
                ],
            ]);

        $response->assertRedirect();

        $this->assertEquals('This poll has not started yet.', session('errors')->getBag('default')->first());

        $this->assertDatabaseMissing('votes', [
            'user_id' => $this->user->getKey(),
            'poll_question_id' => $this->globalPoll->questions->first()->getKey(),
            'poll_question_answer_id' => $this->globalPoll->questions->first()->answers->first()->getKey(),
        ]);

        $this->assertDatabaseMissing('votes', [
            'user_id' => $this->user->getKey(),
            'poll_question_id' => $this->globalPoll->questions->last()->getKey(),
            'poll_question_answer_id' => $this->globalPoll->questions->last()->answers->first()->getKey(),
        ]);
    }

    public function test_vote_in_global_poll_already_voted(): void
    {
        Vote::create([
            'user_id' => $this->user->getKey(),
            'poll_question_id' => $this->globalPoll->questions->first()->getKey(),
            'poll_question_answer_id' => $this->globalPoll->questions->first()->answers->first()->getKey(),
        ]);

        Vote::create([
            'user_id' => $this->user->getKey(),
            'poll_question_id' => $this->globalPoll->questions->last()->getKey(),
            'poll_question_answer_id' => $this->globalPoll->questions->last()->answers->first()->getKey(),
        ]);

        $response = $this->actingAs($this->user)
            ->post("polls/{$this->globalPoll->getKey()}/vote", [
                'questions' => [
                    [
                        'question_id' => $this->globalPoll->questions->first()->getKey(),
                        'answers' => [
                            [
                                'answer_id' => $this->globalPoll->questions->first()->answers->last()->getKey(),
                            ],
                        ],
                    ],
                    [
                        'question_id' => $this->globalPoll->questions->last()->getKey(),
                        'answers' => [
                            [
                                'answer_id' => $this->globalPoll->questions->last()->answers->last()->getKey(),
                            ],
                        ],
                    ],
                ],
            ]);

        $response->assertRedirect();

        $this->assertEquals('You have already voted in this poll.', session('errors')->getBag('default')->first());

        $this->assertDatabaseHas('votes', [
            'user_id' => $this->user->getKey(),
            'poll_question_id' => $this->globalPoll->questions->first()->getKey(),
            'poll_question_answer_id' => $this->globalPoll->questions->first()->answers->first()->getKey(),
        ]);

        $this->assertDatabaseHas('votes', [
            'user_id' => $this->user->getKey(),
            'poll_question_id' => $this->globalPoll->questions->last()->getKey(),
            'poll_question_answer_id' => $this->globalPoll->questions->last()->answers->first()->getKey(),
        ]);

        $this->assertDatabaseMissing('votes', [
            'user_id' => $this->user->getKey(),
            'poll_question_id' => $this->globalPoll->questions->first()->getKey(),
            'poll_question_answer_id' => $this->globalPoll->questions->first()->answers->last()->getKey(),
        ]);

        $this->assertDatabaseMissing('votes', [
            'user_id' => $this->user->getKey(),
            'poll_question_id' => $this->globalPoll->questions->last()->getKey(),
            'poll_question_answer_id' => $this->globalPoll->questions->last()->answers->last()->getKey(),
        ]);
    }

    public function test_vote_in_guild_poll()
    {
        $this->user->characters()->create([
            'name' => 'Test Character',
            'vocation' => VocationEnum::KNIGHT,
        ]);

        GuildCharacter::create([
            'guild_id' => $this->guildPoll->pollable->getKey(),
            'character_id' => $this->user->characters->first()->getKey(),
        ]);

        $response = $this->actingAs($this->user)
            ->post("polls/{$this->guildPoll->getKey()}/vote", [
                'questions' => [
                    [
                        'question_id' => $this->guildPoll->questions->first()->getKey(),
                        'answers' => [
                            [
                                'answer_id' => $this->guildPoll->questions->first()->answers->first()->getKey(),
                            ],
                        ],
                    ],
                    [
                        'question_id' => $this->guildPoll->questions->last()->getKey(),
                        'answers' => [
                            [
                                'answer_id' => $this->guildPoll->questions->last()->answers->first()->getKey(),
                            ],
                        ],
                    ],
                ],
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Your votes have been submitted.');

        $this->assertDatabaseHas('votes', [
            'user_id' => $this->user->getKey(),
            'poll_question_id' => $this->guildPoll->questions->first()->getKey(),
            'poll_question_answer_id' => $this->guildPoll->questions->first()->answers->first()->getKey(),
        ]);

        $this->assertDatabaseHas('votes', [
            'user_id' => $this->user->getKey(),
            'poll_question_id' => $this->guildPoll->questions->last()->getKey(),
            'poll_question_answer_id' => $this->guildPoll->questions->last()->answers->first()->getKey(),
        ]);
    }

    public function test_vote_in_guild_poll_not_member()
    {
        $response = $this->actingAs($this->user)
            ->post("polls/{$this->guildPoll->getKey()}/vote", [
                'questions' => [
                    [
                        'question_id' => $this->guildPoll->questions->first()->getKey(),
                        'answers' => [
                            [
                                'answer_id' => $this->guildPoll->questions->first()->answers->first()->getKey(),
                            ],
                        ],
                    ],
                    [
                        'question_id' => $this->guildPoll->questions->last()->getKey(),
                        'answers' => [
                            [
                                'answer_id' => $this->guildPoll->questions->last()->answers->first()->getKey(),
                            ],
                        ],
                    ],
                ],
            ]);

        $response->assertRedirect();
        $this->assertEquals('You are not a member of this guild.', session('errors')->getBag('default')->first());

        $this->assertDatabaseMissing('votes', [
            'user_id' => $this->user->getKey(),
            'poll_question_id' => $this->guildPoll->questions->first()->getKey(),
            'poll_question_answer_id' => $this->guildPoll->questions->first()->answers->first()->getKey(),
        ]);

        $this->assertDatabaseMissing('votes', [
            'user_id' => $this->user->getKey(),
            'poll_question_id' => $this->guildPoll->questions->last()->getKey(),
            'poll_question_answer_id' => $this->guildPoll->questions->last()->answers->first()->getKey(),
        ]);
    }

    private function createPoll(?Guild $guild = null, PollStatusEnum $status = PollStatusEnum::STARTED): Poll
    {
        $i = 0;

        $poll = Poll::factory()->has(
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
            'status' => $status,
        ]);

        if ($guild) {
            $poll->pollable()->associate($guild);
            $poll->save();
        }

        return $poll;
    }
}
