<?php

namespace App\Http\Controllers\Api\Invoice;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invoice\InvoiceApproveRequest;
use App\Models\Invoice;

class InvoiceApproveController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param InvoiceApproveRequest $request
     * @param Invoice $invoice
     * @return Invoice
     */
    public function __invoke(InvoiceApproveRequest $request, Invoice $invoice): Invoice
    {
        $invoice->update(['approved' => true]);

        return $invoice;
    }
}
