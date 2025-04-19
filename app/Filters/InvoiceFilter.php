<?php
namespace App\Filters;
use App\Filters\ApiFilter;
use Illuminate\Http\Request;

class InvoiceFilter extends ApiFilter{

    protected $safeParms=[
        'customer_id'=>['eq'],
        'amount' =>['eq','lt','gt','lte','gte'],
        'status'=>['eq','ne'],
        'billed_date'=>['eq','lt','gt','lte','gte'],
        'paid_date'=>['eq','lt','gt','lte','gte']
        ];

    protected $columnMap = [
        'customer_id'=>'customer_id',
        'billed_date'=>'billed_date',
        'paid_date'=>'paid_date'
    ];

    protected $operatorMap =[
        'eq' => '=',
        'lt' => '<',
        'gt' => '>',
        'lte' => '<=',
        'gte' => '>=',
        'ne' => "!="
    ];
            
            
}