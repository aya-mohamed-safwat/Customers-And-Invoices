<?php

namespace App\Http\Controllers\Api;

use App\Models\Invoice;
use App\Http\Requests;
use App\Http\Requests\BulkStoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\InvoiceResource;
use App\Http\Resources\v1\InvoiceCollection;
use App\Filters\InvoiceFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;


class InvoiceController extends Controller
{
    
    public function index(Request $request)
    {
        try{
        $filter = (new InvoiceFilter())->transform($request);
         $invoices= new InvoiceCollection(Invoice::where($filter)->paginate());
         return response()->json([
            'status' => 'success',
            'message' => 'invoices fetched successfully',
            'data' => $invoices,
        ], 200);

        }catch(\Throwable $e){
            return response()->json([
                'status' => 'failed',
                'message' => 'invoices fetched failed',
            ], 500);
        }
        
    }



    public function bulkStore(BulkStoreInvoiceRequest $request)
    {
        try {
            $invoice= new InvoiceResource(Invoice::insert($request->validated()));
    
            return response()->json([
                'status' => 'success',
                'message' => 'invices inserted successfully.',
                'data' => $invoice,
            ], 201);
        }
        catch(\Throwable $e){
            return response()->json([
            'status' => 'failed',
            'message' => 'failed to add invoices.',
        ], 500);
    }
    }

 
    public function show($invoiceId)
    {
        $invoice = $this->findById($invoiceId);
        if ($invoice instanceof \Illuminate\Http\JsonResponse) {
            return $invoice;
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Get invoice.',
            'data'=> new InvoiceResource($invoice),
        ], 200);
    }
    
    public function destroy($invoiceId)
    {
        $invoice = $this->findById($invoiceId);
        if ($invoice instanceof \Illuminate\Http\JsonResponse) {
            return $invoice;
        }
        $invoice->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'invoice deleted successfully',
        ],200);
    }

    public function findById($invoiceId){
        $invoice=Invoice::find($invoiceId);
        if(!$invoice){
            return response()->json([
                'status' => 'Failed',
                'message' => 'invoices not found.',
            ], 404);
        }
        else {
            return $invoice;
        }
    }
}
