<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KomentarStoreRequest extends FormRequest
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
            'foto_id' => ['required', 'integer', 'exists:fotos,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'isi' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Harap Mengisi :attribute',
            'string' => 'Harap Inputkan Kata',
            'user_id.exists' => 'User Tidak Ada',
            'date' => 'Harap Inputkan Tanggal',
        ];
    }
    public function attributes(): array
    {
        return [
            'isi' => 'Komentar',
        ];
    }
}
