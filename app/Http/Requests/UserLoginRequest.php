<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'exists:users,username'],
            'password' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Harap Mengisi :attribute',
            'string' => 'Harap Inputkan Kata',
            'username.exists' => 'Username Tidak Ada',
        ];
    }
    public function attributes(): array
    {
        return [
            'username' => 'Username',
            'password' => 'Password',
        ];
    }
}
