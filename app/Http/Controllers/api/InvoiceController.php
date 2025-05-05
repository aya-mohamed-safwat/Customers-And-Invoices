<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Invoice\{UpdateInvoiceRequest,BulkStoreInvoiceRequest,FilterInvoiceRequest};
use App\Http\Controllers\Controller;
use App\Services\InvoiceService;


class InvoiceController extends Controller
{
    protected $invoiceService;

    public function __construct(InvoiceService $invoiceService)
{
    $this->invoiceService = $invoiceService;
}
    
    public function index(FilterInvoiceRequest $request)
    {
        return $this->invoiceService->filterInvoice($request);
    }


    public function bulkStore(BulkStoreInvoiceRequest $request)
    {
        return $this->invoiceService->createInvoices($request);
    }

 
    public function show($invoiceId)
    {
        return $this->invoiceService->showInvoice($invoiceId);
    }

    public function update(UpdateInvoiceRequest $request,int $invoiceId)
    {
        return $this->invoiceService->updateInvoice($request , $invoiceId);
    }
    
    public function destroy($invoiceId)
    {
        return $this->invoiceService->deleteInvoice($invoiceId);
    }

 
}
