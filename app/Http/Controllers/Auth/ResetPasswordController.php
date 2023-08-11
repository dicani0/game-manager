<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\SendResetPasswordMail;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    public function __invoke(ResetPasswordRequest $request, SendResetPasswordMail $action): RedirectResponse
    {
        $result = $action->handle($request->validated('email'));

        return match ($result) {
            Password::RESET_LINK_SENT => redirect()->route('login')->with('success', __($result)),
            default => back()->withErrors(['error' => __($result)]),
        };
    }
}
