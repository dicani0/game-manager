<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\SetNewPassword;
use App\Data\Auth\NewPasswordFormDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\NewPasswordFormRequest;
use App\Http\Requests\Auth\NewPasswordRequest;
use App\Processes\Auth\ResetPasswordProcess;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;
use Inertia\Inertia;
use Inertia\Response;

class NewPasswordController extends Controller
{

    public function get(NewPasswordFormRequest $request, string $token): Response
    {
        $dto = NewPasswordFormDto::from([
            'email' => $request->get('email'),
            'token' => $token,
        ]);

        return Inertia::render('Auth/NewPassword', $dto->toArray());
    }

    public function post(NewPasswordRequest $request, SetNewPassword $action): RedirectResponse
    {
        $status = $action->handle($request->toDto());

        return match ($status) {
            Password::PASSWORD_RESET => redirect()->route('login')->with('success', __($status)),
            default => back()->withErrors(['email' => __($status)]),
        };
    }
}
