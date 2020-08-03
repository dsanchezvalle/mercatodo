<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookFilterRequest extends FormRequest
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
        return [
            'filter.author' => 'nullable|string|between:2,255',
            'filter.title' => 'nullable|string|between:2,255',
            'filter.isbn' => 'nullable|numeric|digits:13',
            'filter.status' => 'nullable',
        ];
    }
}
