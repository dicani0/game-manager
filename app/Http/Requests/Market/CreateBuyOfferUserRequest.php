<?php

namespace App\Http\Requests\Market;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CreateBuyOfferUserRequest extends CreateBuyOfferRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        /** @var User $user */
        $user = $this->route('user');

        return $user->isNot(Auth::user());
    }
}
