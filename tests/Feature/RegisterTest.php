<?php

use App\Data\Auth\RegisterUserDto;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Processes\Auth\RegisterProcess;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_register(): void
    {
        Notification::fake();

        $request = new RegisterRequest();
        $request->merge([
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        /** @var RegisterProcess $process */
        $process = app(RegisterProcess::class);
        $dto = RegisterUserDto::from($request->all());
        $process->run($dto);
        $this->assertDatabaseHas('users', [
            'name' => 'test',
            'email' => 'test@example.com',
        ]);
    }

    public function test_register_fail(): void
    {
        $this->expectException(ValidationException::class);
        User::factory()->create([
            'email' => 'test@example.com',
        ]);

        $request = new RegisterRequest();
        $request->merge([
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $request->validate($request->rules());
    }
}
