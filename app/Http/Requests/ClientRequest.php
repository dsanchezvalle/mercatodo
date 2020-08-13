<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:2', 'max:255', 'regex:/^[a-zA-Z0-9\s\.]+$/'],
            'surname' => ['required', 'string', 'min:2', 'max:255', 'regex:/^[a-zA-Z0-9\s\.]+$/'],
            'document_type' => ['required', 'string', 'max:255'],
            'document_number' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->client->id)],
            'phone_number' => ['required', 'string', 'max:255'],
            'is_active' => ['nullable'],
        ];
    }
}
