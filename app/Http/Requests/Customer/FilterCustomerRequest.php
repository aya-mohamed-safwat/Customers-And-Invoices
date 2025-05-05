<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class FilterCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name.eq' => ['sometimes', 'string', 'max:100'],
            'email.eq' => ['sometimes', 'email'],
            'type.eq' => ['sometimes', 'in:B,I'],
            'address.eq' => ['sometimes', 'string'],
            'city.eq' => ['sometimes', 'string'],
            'state.eq' => ['sometimes', 'string'],
            'postalcode.eq' => ['sometimes', 'numeric'],
            'postalcode.gt' => ['sometimes', 'numeric'],
            'postalcode.lt' => ['sometimes', 'numeric'],
            'IncludeInvoices' => ['sometimes', 'boolean'],
        ];
    }
}
