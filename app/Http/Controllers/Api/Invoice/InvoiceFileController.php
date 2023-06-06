<?php

namespace App\Http\Controllers\Api\Invoice;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invoice\InvoiceFileLoadRequest;
use App\Models\Invoice;
use Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

class InvoiceFileController extends Controller
{
    /**
     * Get invoice file.
     *
     * @param Invoice $invoice
     * @return BinaryFileResponse
     */
    public function show(Invoice $invoice): BinaryFileResponse
    {
        abort_if(Storage::disk('private')->missing($invoice->file_url), Response::HTTP_NOT_FOUND);

        return response()->file(Storage::disk('private')->path($invoice->file_url), [
            'Content-Length' => Storage::disk('private')->size($invoice->file_url)
        ]);
    }

    /**
     * Change invoice file.
     *
     * @param InvoiceFileLoadRequest $request
     * @param Invoice $invoice
     * @return Invoice
     */
    public function store(InvoiceFileLoadRequest $request, Invoice $invoice): Invoice
    {
        Storage::disk('private')->delete($invoice->file_url);
        $fileUrl = $request->file('file')->store('invoice', 'private');
        $invoice->update(['file_url' => $fileUrl]);

        return $invoice;
    }
}
