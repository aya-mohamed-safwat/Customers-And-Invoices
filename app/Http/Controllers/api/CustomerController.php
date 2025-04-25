<?php

namespace App\Http\Controllers\Api;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\CustomerResource;
use App\Http\Resources\v1\CustomerCollection;
use App\Filters\CustomersFilter;
use App\Http\Requests\FilterCustomerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index(FilterCustomerRequest $request)
    {
        try {
        $filters = (new CustomersFilter())->transform($request);
       
        $customer = Customer::where($filters);

        if($request->boolean('IncludeInvoices')){
            $customer->with('invoices');
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Customers fetched successfully',
            'data' => new CustomerCollection($customer->paginate()->appends($request->query())),
        ], 200);
        
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'failed',
            'message' => 'Something went wrong while fetching customers.',
        ], 500);
    }
    }


    public function store(StoreCustomerRequest $request)
    {
        try {
        $customer= new CustomerResource(Customer::create($request->validated()));

        return response()->json([
            'status' => 'success',
            'message' => 'Customer created successfully.',
            'data' => $customer,
        ], 201);

    } catch (\Throwable $e) {
        return response()->json([
            'status' => 'Failed',
            'message' => 'Failed to create customer.'. $e->getMessage(),
            'data' => null,
        ], 500);
    }
    }

    public function show(Request $request , $customerId)
    {
        $customer = $this->findById($customerId);
        if ($customer instanceof \Illuminate\Http\JsonResponse) {
            return $customer;
        }

        $includeInvoices = $request->query('IncludeInvoices',false);
        if($includeInvoices){
            $customer= $customer->Load('invoices');
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Get Customer.',
            'data'=> new CustomerResource($customer),
        ], 200);
       
    }

    

    public function update(UpdateCustomerRequest $request, $customerId)
    {
        $customer=$this->findById($customerId);
        if ($customer instanceof \Illuminate\Http\JsonResponse) {
            return $customer;
        }
        
        DB::beginTransaction();
        try {  
            $customer->update($request->validated());
    
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'customer is updated Successfully',
                'data' => new CustomerResource($customer),
            ],200);

        } catch (\Exception $e) {
            DB::rollBack();
    
            return response()->json([
                'status' => 'Failed',
                'message' => ' Failed to update customer'. $e->getMessage(),
                'data' => null
            ],500);
        }
    }

    public function destroy($customerId)
    {
        $customer = $this->findById($customerId);
        if ($customer instanceof \Illuminate\Http\JsonResponse) {
            return $customer;
        }

        $customer->invoices()->delete();
        $customer->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Customer and related invoices deleted successfully',
        ],200);
    }

    public function findById($customerId){
        $customer=Customer::find($customerId);
        if(!$customer){
            return response()->json([
                'status' => 'Failed',
                'message' => 'Customer not found.',
            ], 404);
        }
        else {
            return $customer;
        }
    }
}