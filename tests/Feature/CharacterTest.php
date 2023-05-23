<?php


use App\Http\Middleware\VerifyCsrfToken;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class CharacterTest extends TestCase
{
//    use WithoutMiddleware;
    use RefreshDatabase;

    /**
     * A basic test example.
     */

    public User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);
    }

    public function test_create_character(): void
    {
        $response = $this->withoutMiddleware(VerifyCsrfToken::class)->actingAs($this->user)->post('/characters', [
            'name' => 'test',
            'vocation' => 'knight',
        ]);

        $response->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Character/Character')
            ->has('characters', 1)
            ->where('characters.0.name', 'test')
            ->where('characters.0.vocation', 'knight')
        );
    }

    public function test_create_character_unauthorized(): void
    {
        $response = $this->withoutMiddleware(VerifyCsrfToken::class)->post('/characters', [
            'name' => 'test',
            'vocation' => 'knight',
        ]);
        $response->assertRedirect('/auth/login');
    }
}
