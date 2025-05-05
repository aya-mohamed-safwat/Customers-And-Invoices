<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Customer\{StoreCustomerRequest,UpdateCustomerRequest,FilterCustomerRequest};
use App\Http\Controllers\Controller;
use App\Services\CustomerService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
protected $customerService;

public function __construct(CustomerService $customerService)
{
    $this->customerService = $customerService;
}

    public function index(FilterCustomerRequest $request)
    {
       return $this->customerService->filterCustomers($request);
    }


    public function store(StoreCustomerRequest $request)
    {
        $data = $request->validated();
      return $this->customerService->createCustomer($data);
    }

    public function show(Request $request , $customerId)
    {
      return $this->customerService->showCustomer($request,$customerId) ;
    }

    public function update(UpdateCustomerRequest $request, $customerId)
    {
        return $this->customerService->updateCustomer($request,$customerId) ;
    }

    public function destroy($customerId)
    {
        return $this->customerService->deleteCustomer($customerId) ;
       
    }

 
}