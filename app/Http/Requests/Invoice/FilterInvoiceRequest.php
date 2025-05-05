<?php

namespace App\Http\Requests\Invoice;

use Illuminate\Foundation\Http\FormRequest;

class FilterInvoiceRequest extends FormRequest
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
            'customer_id.eq' => ['sometimes', 'integer'],
            'status.eq' => ['sometimes', 'string'],
            'amount.eq' => ['sometimes', 'numeric'],
            'amount.gt' => ['sometimes', 'numeric'],
            'amount.lt' => ['sometimes', 'numeric'],
            'billed_date.eq'=>['sometimes','date_format:Y-m-d'],
            'paid_date.eq'=>['sometimes','date_format:Y-m-d'],
        ];
    }
}
