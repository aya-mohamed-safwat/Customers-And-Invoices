<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
           'email' => 'required|email|exists:users,email',
           'password' => 'required|string|min:6',
           'code'=>'required|integer'

        ];
    }
    public function messages(): array
    {
        return [
    
            'email.required' => 'The email field is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.exists' => 'Theis email is not exist.',
    
            'password.required' => 'The email field is required.',
            'password.min' => 'The password should be greater than 6 characters.',
        ];
    }
}
