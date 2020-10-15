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
        return [
            'filter.author' => 'nullable|string|between:2,80|regex:/^[a-zA-Z0-9áéíóúüñÑ\s\.]+$/',
            'filter.title' => 'nullable|string|between:2,100|regex:/^[a-zA-Z0-9áéíóúüñÑ\s\.]+$/',
            'filter.isbn' => 'nullable|numeric|digits:13',
            'filter.status' => 'nullable|in:true,false',
        ];
    }
}
