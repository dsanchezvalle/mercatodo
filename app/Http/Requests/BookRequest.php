<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $id = $this->book->id ?? null;

        return [
            'isbn' => ['required', 'string', 'digits:13', "unique:books,isbn,$id"],
            'title' => ['required', 'string', 'min: 2', 'max:100', 'regex:/^[a-zA-Z0-9áéíóúüñÑ\s\.]+$/'],
            'author' => ['required', 'string', 'min: 2', 'max:80', 'regex:/^[a-zA-Z0-9áéíóúüñÑ\s\.]+$/'],
            'price' => ['required', 'numeric', 'min:1', 'max:500000'],
            'stock' => ['required', 'numeric', 'min:1', 'max:1000' ],
            'file' => ['image', 'mimes:jpeg,bmp,png,jpg', 'max:200'],
            'image_path' => ['string', 'min: 2', 'max:100'],
            'is_active' => ['nullable', 'in:on,null'],
        ];
    }
}
