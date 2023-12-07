<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest as BaseEmailVerificationRequest;

class EmailVerificationRequest extends BaseEmailVerificationRequest
{
    public function authorize()
    {
        $user = $this->findUser();

        if (! hash_equals(sha1($user->getEmailForVerification()), (string) $this->route('hash'))) {
            return false;
        }

        return true;
    }

    public function fulfill()
    {
        $user = $this->findUser();

        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();

            event(new Verified($user));
        }
    }

    public function findUser(): User
    {
        return User::query()->findOrFail($this->route('id'));
    }
}
