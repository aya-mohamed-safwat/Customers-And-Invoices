<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class BulkStoreInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user=$this->user();
    
        return $user != null && $user->tokenCan('create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            '*.customer_id'=>['required','integer'],
            '*.amount'=>['required','numeric'],
            '*.status'=>['required',Rule::in(['B','V','P'])],
           '*.billed_date'=>['required','date_format:Y-m-d'],
            '*.paid_date'=>['date_format:Y-m-d','nullable'],
        ];
    }

    protected function prepareForValidation(){
        $data=[];
    foreach($this->toArray() as $obj){
        $obj['customer_id']=$obj['customer_id'] ?? null;
        $obj['billed_date']=$obj['billed_date'] ?? null;
        $obj['paid_date']=$obj['paid_date'] ?? null;

        $data[]=$obj;
    }
    $this->merge($data);
    }
}
