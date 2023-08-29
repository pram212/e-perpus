<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
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
            'title' => ['required'],
            'isbn' => ['required'],
            'catalog_id' => ['required'],
            'author' => ['required'],
            'publisher' => ['required'],
            'published_at' => ['required'],
            // 'stock' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'isbn wajib diisi',
            'isbn.required' => 'isbn wajib diisi',
            'isbn.unique' => 'isbn telah terdaftar',
            'catalog_id.required' => 'katalog wajib diisi',
            'author.required' => 'pengarang wajib diisi',
            'publisher.required' => 'penerbit wajib diisi',
            'published_at.required' => 'tahun terbit wajib diisi',
            // 'stock.required' => 'stock wajib diisi',
        ];
    }
}
