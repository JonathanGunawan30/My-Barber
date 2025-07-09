<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $customerId = $this->route('customer');

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', "unique:customers,email,{$customerId}"],
            'phone' => ['nullable', 'string', 'max:20', "unique:customers,phone,{$customerId}"],
            'password' => ['nullable', 'string', 'min:6'],
            'google_id' => ['nullable', 'string', "unique:customers,google_id,{$customerId}"],
            'avatar' => ['nullable', 'string'],
        ];
    }
}
