<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user() && auth()->user()->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'max:255', 'unique:users,username,'.$this->route('user')->id],
            'email' => [
                'required', 'string', 'lowercase', 'email', 'max:255',
                'unique:users,email,'.$this->route('user')->id
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];
    }
}
