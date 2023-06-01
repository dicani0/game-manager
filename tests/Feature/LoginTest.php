<?php

namespace Tests\Feature;

use App\Actions\Auth\LoginUser;
use App\Data\Auth\LoginUserDto;
use App\Exceptions\Auth\InvalidCredentialsException;
use App\Http\Middleware\VerifyCsrfToken;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
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

    public function test_login_ok(): void
    {
        $this->post('/auth/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);
        $this->assertAuthenticated();
    }

    public function test_login_fail(): void
    {
        $this->expectException(InvalidCredentialsException::class);
        /** @var LoginUser $loginUser */
        $loginUser = app(LoginUser::class);
        $dto = LoginUserDto::from([
            'email' => 'test@example.com',
            'password' => 'aaa',
        ]);
        $loginUser->handle($dto);
    }
}
