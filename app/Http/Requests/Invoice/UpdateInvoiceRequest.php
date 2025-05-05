<?php

namespace App\Http\Requests\Invoice;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInvoiceRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
                'customer_id'=>['sometimes','required','integer'],
                'amount'=>['sometimes','required','numeric'],
                'status'=>['sometimes','required',Rule::in(['B','V','P'])],
               'billed_date'=>['sometimes','required','date_format:Y-m-d'],
                'paid_date'=>['sometimes','date_format:Y-m-d','nullable'],
        ];
    }
}
