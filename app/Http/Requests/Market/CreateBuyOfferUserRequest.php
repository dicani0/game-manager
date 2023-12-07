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

    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'items.*.amount' => ['required', 'numeric', 'min:1', function ($attribute, $value, $fail) {
                /** @var User $user */
                $user = $this->route('user');
                
                $item = $user->items()->where('item_id', $this->input('items.*.id'))->first();

                if (is_null($item) || $item->pivot->available_amount < $value) {
                    $fail(__('User does not have enough items.'));
                }
            }],
        ]);
    }
}
