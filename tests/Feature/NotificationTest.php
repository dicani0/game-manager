<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Carbon;
use Inertia\Testing\AssertableInertia;
use Str;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    public User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->user->notifications()->createMany([
            [
                'id' => Str::uuid(),
                'type' => 'App\Notifications\NewUserNotification',
                'data' => [
                    'message' => 'New user registered',
                    'link' => '/users',
                ],
            ],
            [
                'id' => Str::uuid(),
                'type' => 'App\Notifications\NewUserNotification',
                'data' => [
                    'message' => 'New user registered',
                    'link' => '/users',
                ],
            ],
            [
                'id' => Str::uuid(),
                'type' => 'App\Notifications\NewUserNotification',
                'data' => [
                    'message' => 'New user registered',
                    'link' => '/users',
                ],
            ],
        ]);
    }

    /**
     * A basic feature test example.
     */
    public function test_get_notifications(): void
    {
        $this->actingAs($this->user)
            ->get('/notifications/all')
            ->assertInertia(fn(AssertableInertia $page) => $page
                ->component('Notifications/Notifications')
                ->has('all_notifications.data', 3)
                ->has('all_notifications.data', fn(AssertableInertia $page) => $page
                    ->where('0.id', $this->user->notifications->get(0)->id)
                    ->where('1.id', $this->user->notifications->get(1)->id)
                    ->where('2.id', $this->user->notifications->get(2)->id)
                    ->etc()
                )
            );
    }

    public function test_read_notification(): void
    {
        Carbon::setTestNow();

        $this->actingAs($this->user)
            ->get('/notifications/' . $this->user->notifications->get(0)->id . '/read')
            ->assertRedirect('/users');

        $this->assertDatabaseHas('notifications', [
            'id' => $this->user->notifications->get(0)->id,
            'read_at' => now(),
        ]);

    }

    public function test_read_notification_unauthorized(): void
    {
        $anotherUser = User::factory()->create();

        $this->actingAs($anotherUser)->get('/notifications/' . $this->user->notifications->get(0)->id . '/read');

        $this->assertEquals(session('errors')->getBag('default')->first(), 'This action is unauthorized.');

    }
}
