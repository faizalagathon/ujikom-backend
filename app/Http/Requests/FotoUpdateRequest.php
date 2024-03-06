<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FotoUpdateRequest extends FormRequest
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
            'judul' => ['required', 'string'],
            'deskripsi' => ['required', 'string'],
            'tanggal' => ['required', 'date'],
            'file' => ['required', 'string'],
            'album_id' => ['required', 'integer', 'exists:albums,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ];
    }
}
