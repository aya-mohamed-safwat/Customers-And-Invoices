<?php
namespace App\Filters;
use App\Filters\ApiFilter;
use Illuminate\Http\Request;

class CustomersFilter extends ApiFilter{

    protected $safeParms=[
        'name'=>['eq'],
        'type' =>['eq'],
        'email'=>['eq'],
        'address'=>['eq'],
        'city'=>['eq'],
        'postalcode'=>['eq','gt','lt'],
        'state'=>['eq']
        ];

    protected $columnMap = ['postalcode'=>'postalcode'];

    protected $operatorMap =[
        'eq' => '=',
        'lt' => '<',
        'gt' => '>',
        'lte' => '<=',
        'gte' => '>=',
    ];
            
            
}