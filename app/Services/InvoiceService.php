<?php
namespace App\Services;

use App\Models\Invoice;
use Illuminate\Http\JsonResponse;
use App\Filters\InvoiceFilter;
use App\Http\Requests\Invoice\{UpdateInvoiceRequest,BulkStoreInvoiceRequest,FilterInvoiceRequest};
use App\Http\Resources\v1\{InvoiceResource,InvoiceCollection};
use Illuminate\Support\Facades\DB;

use function App\Helpers\apiResponse;

class InvoiceService{


    public function filterInvoice(FilterInvoiceRequest $request):JsonResponse
    {
        try{
        $filter = (new InvoiceFilter())->transform($request);
         $invoices= new InvoiceCollection(Invoice::where($filter)->paginate());

         return apiResponse('success', 'invoices fetched successfully.', $invoices, 201);

        }catch(\Throwable $e){
            return apiResponse('failed', 'Something went wrong while fetching invoices.', 500);
        }
    }


    public function createInvoices(BulkStoreInvoiceRequest $request):JsonResponse
    {
        try {
            $invoice= new InvoiceResource(Invoice::insert($request->validated()));
            return apiResponse('success', 'invoices inserted successfully.', $invoice, 201);
        }
        catch(\Throwable $e){
            return apiResponse('failed', 'failed to add invoices.', 500);
    }
    }

    public function showInvoice(int $invoiceId):JsonResponse
    {
        $invoice = Invoice::find($invoiceId);
     if (!$invoice) {
         return apiResponse('failed','Invoices not found.',404);
    }
    $invoice = new InvoiceResource($invoice);
        return apiResponse('success', $invoice, 200);

    }


public function updateInvoice(UpdateInvoiceRequest $request,int $invoiceId):JsonResponse
{
    $invoice = Invoice::find($invoiceId);
    if (!$invoice) {
        return apiResponse('failed','Invoice not found.',404);
    }
    
    DB::beginTransaction();
    try {  
        $invoice->update($request->validated());

        DB::commit();

        $invoice =new InvoiceResource($invoice);
        return apiResponse('success', 'invoice updated Successfully', $invoice, 201);

    } catch (\Exception $e) {
        DB::rollBack();

        return apiResponse('failed',' Failed to update invoice',500);
    }
}


public function deleteInvoice(int $invoiceId):JsonResponse
{
    $invoice = Invoice::find($invoiceId);
 if (!$invoice) {
     return apiResponse('failed','Invoices not found.',404);
 }
    $invoice->delete();
    return apiResponse('success', 'invoice deleted successfully', 200);
}

 }