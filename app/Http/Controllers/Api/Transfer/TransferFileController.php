<?php

namespace App\Http\Controllers\Api\Transfer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transfer\TransferFileLoadRequest;
use App\Models\Transfer;
use Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

class TransferFileController extends Controller
{
    /**
     * Get transfer file.
     *
     * @param Transfer $transfer
     * @return BinaryFileResponse
     */
    public function show(Transfer $transfer): BinaryFileResponse
    {
        abort_if(Storage::disk('private')->missing($transfer->file_url), Response::HTTP_NOT_FOUND);
            // TODO: Return error message?

        return response()->file(Storage::disk('private')->path($transfer->file_url));
    }

    /**
     * Change transfer file.
     *
     * @param TransferFileLoadRequest $request
     * @param Transfer $transfer
     * @return Transfer
     */
    public function store(TransferFileLoadRequest $request, Transfer $transfer): Transfer
    {
        //Storage::disk('private')->delete($invoice->file_url);
        $fileUrl = $request->file('file')->store('invoice', 'private');
        $transfer->update(['file_url' => $fileUrl]);

        return $transfer;
    }
}
