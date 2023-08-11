<?php

namespace App\Http\Requests\Auth;

use App\Data\Auth\NewPasswordDto;
use Illuminate\Foundation\Http\FormRequest;

class NewPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'max:255', 'exists:users,email'],
            'token' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function toDto(): NewPasswordDto
    {
        return NewPasswordDto::from([
            'email' => $this->input('email'),
            'token' => $this->input('token'),
            'password' => $this->input('password'),
            'password_confirmation' => $this->input('password_confirmation'),
        ]);
    }
}
