<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegistrasiRequest extends FormRequest
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
            'username' => ['required', 'string', 'unique:users,username'],
            'password' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'nama_lengkap' => ['required', 'string'],
            'alamat' => ['required', 'string'],
        ];
    }
    public function messages(): array
    {
        return [
            'required' => 'Harap Mengisi :attribute',
            'string' => 'Harap Inputkan Kata',
            'username.unique' => 'Username Sudah Ada',
            'email.unique' => 'Email Sudah Ada',
            'email' => 'Harap Inputkan Email',
        ];
    }
    public function attributes(): array
    {
        return [
            'username' => 'Username',
            'password' => 'Password',
            'email' => 'Email',
            'nama_lengkap' => 'Nama Lengkap',
            'alamat' => 'Alamat',
        ];
    }
}
