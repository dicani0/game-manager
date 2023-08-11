<?php

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    public function test_forgot_password_form(): void
    {
        $response = $this->get('auth/forgot-password/')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page->component('Auth/ForgotPassword'));
    }

    public function test_forgot_password_form_submitted(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'email' => 'test@example.com',
        ]);
        $response = $this->post('auth/forgot-password/', [
            'email' => $user->email,
        ]);

        $response->assertRedirect('auth/login');

        $this->assertDatabaseHas('password_reset_tokens', [
            'email' => $user->email,
        ]);

        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function test_new_password_form(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
        ]);

        $token = Password::createToken($user);

        $response = $this->get("auth/reset-password/{$token}?email={$user->email}");

        $response->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page->component('Auth/NewPassword'));
    }

    public function test_set_new_password(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('oldpassword'),
        ]);

        $token = Password::createToken($user);

        $newPassword = 'password';

        $response = $this->post("auth/reset-password", [
            'email' => $user->email,
            'token' => $token,
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ]);

        $user->refresh();

        $this->assertTrue(Hash::check($newPassword, $user->password));
    }

    public function test_set_new_password_wrong_token(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('oldpassword'),
        ]);

        $token = Password::createToken($user);

        $newPassword = 'password';

        $response = $this->post("auth/reset-password", [
            'email' => $user->email,
            'token' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaa',
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ]);

        $response->assertRedirect()->assertSessionHasErrors('email');

        $user->refresh();

        $this->assertTrue(!Hash::check($newPassword, $user->password));
    }
}
