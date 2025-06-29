<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCustomerRequest extends FormRequest
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

    public function rules()
    {
        return [
                'name'=>['sometimes','required', 'string', 'max:100'],
                'type'=>['sometimes','required',Rule::in(['B','I'])],
                'email'=>['sometimes','required','email', 'max:150','string',
                Rule::unique('customers')->ignore($this->route('customer'))],
               'address'=>['sometimes','required', 'string', 'max:255'],
                'city'=>['sometimes','required', 'string', 'max:100'],
               'state'=>['sometimes','required', 'string', 'max:100'],
                'postalcode'=>['sometimes','required', 'digits_between:4,20'],
        ];
    }
  
    public function messages(): array
{
    return [
        'name.required' => 'The name field is required.',
        'name.string' => 'The name must be a string.',
        'name.max' => 'The name may not be greater than 100 characters.',

        'type.required' => 'The type field is required.',
        'type.in' => 'The selected type is invalid. It must be either B (Business) or I (Individual).',

        'email.required' => 'The email field is required.',
        'email.email' => 'Please provide a valid email address.',
        'email.max' => 'The email may not be greater than 150 characters.',
        'email.unique' => 'The email is already exist.',

        'address.required' => 'The address field is required.',
        'address.string' => 'The address must be a string.',
        'address.max' => 'The address may not exceed 255 characters.',

        'city.required' => 'The city field is required.',
        'city.string' => 'The city must be a string.',
        'city.max' => 'The city may not exceed 100 characters.',

        'state.required' => 'The state field is required.',
        'state.string' => 'The state must be a string.',
        'state.max' => 'The state may not exceed 100 characters.',

        'postalcode.required' => 'The postal code is required.',
        'postalcode.digits_between' => 'The postal code must be between 4 and 20 digits.',
    ];
}
}
