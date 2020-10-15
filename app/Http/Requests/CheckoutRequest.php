<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
            'street' => ['required', 'string', 'min: 2', 'max:100'],
            'city' => ['required', 'string', 'min: 2', 'max:50'],
            'state' => ['required', 'string', 'min: 2', 'max:50'],
            'country' => ['required', 'string', 'min: 2', 'max:2', 'in:CO'],
            'postal_code' => ['nullable', 'string', 'min: 2', 'max:16'],
            'mobile' => ['nullable', 'string', 'min: 2', 'max:30'],
        ];
    }
}
