<?php

namespace App\Http\Requests;

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
        $user=$this->user();
    
        return $user != null && $user->tokenCan('update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $method=$this->method();
        if($method=='Put')
        {
        return [
                'name'=>['required'],
                'type'=>['required',Rule::in(['B','I'])],
                'email'=>['required','email'],
               'address'=>['required'],
                'city'=>['required'],
               'state'=>['required'],
                'postalcode'=>['required'],
        ];
    }
    else {
        return [
            'name'=>['sometimes','required'],
            'type'=>['sometimes','required',Rule::in(['B','I'])],
            'email'=>['sometimes','required','email'],
           'address'=>['sometimes','required'],
            'city'=>['sometimes','required'],
           'state'=>['sometimes','required'],
            'postalcode'=>['sometimes','required'],
    ];
    }
    }
    protected function prepareForValidation(){
        if($this->postalcode){
        $this->merge([
            'postalcode'=>$this->postalcode
        ]);
    }
    }
}
