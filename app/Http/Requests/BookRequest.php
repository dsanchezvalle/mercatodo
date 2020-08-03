<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'isbn' => ['required', 'string', 'min:10', 'max:13', "unique:books,isbn,$id"],
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'max:500000'],
            'stock' => ['required', 'numeric', 'max:1000', ],
            'image_path' => ['string|image'],
        ];
    }
}
