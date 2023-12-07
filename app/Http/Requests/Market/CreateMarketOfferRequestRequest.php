<?php

namespace App\Http\Requests\Market;

use App\Models\Market\MarketOffer;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateMarketOfferRequestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return !$this->getMarketOffer()->creator->is($this->user())
            && $this->getMarketOffer()->offers->where('user_id', $this->user()->getKey())->isEmpty();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'message' => ['nullable', 'string'],
            'at_price' => ['nullable', 'integer'],
            'lat_price' => ['nullable', 'integer'],
            'items' => ['required', 'array'],
            'items.*.item_id' => ['required', 'integer', 'exists:items,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
        ];
    }


    public function getMarketOffer(): MarketOffer
    {
        /** @var MarketOffer $marketOffer */
        $marketOffer = $this->route('marketOffer');

        return $marketOffer;
    }
}
