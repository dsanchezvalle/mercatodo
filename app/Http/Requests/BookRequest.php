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
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->book->id ?? null;
        return [
            'isbn' => ['required', 'string', 'digits:13', "unique:books,isbn,$id"],
            'title' => ['required', 'string', 'min: 2', 'max:255', 'regex:/^[a-zA-Z0-9\s\.]+$/'],
            'author' => ['required', 'string', 'min: 2', 'max:255', 'regex:/^[a-zA-Z0-9\s\.]+$/'],
            'price' => ['required', 'numeric', 'min:1', 'max:500000'],
            'stock' => ['required', 'numeric', 'min:1', 'max:1000' ],
            'image_path' => ['string'],
            'file' => ['image', 'mimes:jpeg,bmp,png', 'max:200'],
        ];
    }
}
