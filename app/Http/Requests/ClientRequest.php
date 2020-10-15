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
            'name' => ['required', 'string', 'min:2', 'max:50', 'regex:/^[a-zA-Z0-9áéíóúüñÑ\s\.]+$/'],
            'surname' => ['required', 'string', 'min:2', 'max:50', 'regex:/^[a-zA-Z0-9áéíóúüñÑ\s\.]+$/'],
            'document_type' => ['required', 'string', 'max:2'],
            'document_number' => ['required', 'string', 'max:50', 'alpha_num'],
            'email' => ['required', 'string', 'email', 'max:100', Rule::unique('users')->ignore($this->client->id)],
            'phone_number' => ['required', 'string', 'max:50'],
            'is_active' => ['nullable', 'in:on,null'],
        ];
    }
}
