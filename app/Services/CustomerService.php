<?php
namespace App\Services;

use App\Models\Customer;
use Illuminate\Http\{JsonResponse,Request};
use App\Filters\CustomersFilter;
use App\Http\Requests\Customer\{FilterCustomerRequest,UpdateCustomerRequest};
use App\Http\Resources\v1\{CustomerResource,CustomerCollection};
use Illuminate\Support\Facades\DB;

use function App\Helpers\apiResponse;

class CustomerService{
public function filterCustomers(FilterCustomerRequest $request):JsonResponse
{
    try {
        $filters = (new CustomersFilter())->transform($request);
       
        $customer = Customer::where($filters);

        if($request->boolean('IncludeInvoices')){
            $customer->with('invoices');
        }
        $customer = new CustomerCollection($customer->paginate()->appends($request->query()));
        return apiResponse('success', 'Customer fetched successfully.', $customer, 201);
        
    } catch (\Exception $e) {
        return apiResponse('failed', 'Something went wrong while fetching customers.', null, 500);
    }
}

public function createCustomer(array $data):JsonResponse{

    try {
        $customer= new CustomerResource(Customer::create($data));
        return apiResponse('success', 'Customer created successfully.', $customer, 201);

    } catch (\Throwable $e) {
        return apiResponse('failed', 'Failed to create customer.', null, 500);
    }
}

public function showCustomer(Request $request ,int $customerId):JsonResponse
{
    $customer = Customer::find($customerId);
    if (!$customer) {
        return apiResponse('failed','Customer not found.',404);
    }

    $includeInvoices = $request->query('IncludeInvoices',false);
    if($includeInvoices){
        $customer= $customer->Load('invoices');
    }
    $customer = new CustomerResource($customer);
    return apiResponse('success', $customer, 200);
   
}

public function updateCustomer(UpdateCustomerRequest $request,int $customerId):JsonResponse
{
    $customer = Customer::find($customerId);
    if (!$customer) {
        return apiResponse('failed','Customer not found.',404);
    }
    
    DB::beginTransaction();
    try {  
        $customer->update($request->validated());

        DB::commit();

        $customer =new CustomerResource($customer);
        return apiResponse('success', 'customer updated Successfully', $customer, 201);

    } catch (\Exception $e) {
        DB::rollBack();

        return apiResponse('failed',' Failed to update customer',500);
    }
}

public function deleteCustomer(int $customerId):JsonResponse
    {
        $customer = Customer::find($customerId);
        if (!$customer) {
            return apiResponse('failed','Customer not found.',404);
        }

        $customer->invoices()->delete();
        $customer->delete();
        return apiResponse('success', 'Customer and related invoices deleted successfully', 201);
    }




}