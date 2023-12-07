<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class SettingsTest extends TestCase
{
    /**
     * A basic test example.
     */
    public User $user;

    public function test_render_settings_page_unauthenticated(): void
    {
        $this->get('/auth/settings')
            ->assertRedirect('/auth/login');
    }

    public function test_render_settings_page_authenticated(): void
    {
        $response = $this->actingAs($this->user)
            ->get('/auth/settings');

        $response->assertInertia(fn (AssertableInertia $page) => $page->component('Auth/Settings')
            ->has('user')
            ->where('user.discord_name', $this->user->discord_name)
            ->where('user.private', $this->user->private)
            ->etc()
        );
    }

    public function test_update_settings(): void
    {
        $this->user->update([
            'discord_name' => null,
            'private' => false,
        ]);

        $this->actingAs($this->user)
            ->patch('/auth/settings', [
                'discord_name' => 'test',
                'private' => true,
                'password' => 'asdasdasd',
                'password_confirmation' => 'asdasdasd',
            ])
            ->assertRedirect('/');

        $this->assertDatabaseHas('users', [
            'discord_name' => 'test',
            'private' => true,
        ]);

        $this->assertTrue(Hash::check('asdasdasd', $this->user->fresh()->password));
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);
    }
}
