<?php

namespace App\Http\Controllers\Api\Invoice;

use App\Http\Controllers\Controller;
use App\Http\Requests\License\LicenseCreateRequest;
use App\Models\Invoice;
use App\Models\License;
use App\Repositories\LicenseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class InvoiceLicenseController extends Controller
{
    /**
     * @var LicenseRepository
     */
    private LicenseRepository $licenseRepository;

    public function __construct()
    {
        $this->licenseRepository = app(LicenseRepository::class);
    }

    /**
     * Display a listing of the items that belongs to specified invoice.
     *
     * @param mixed $invoiceId
     * @return Collection
     */
    public function index($invoiceId): Collection
    {
        return $this->licenseRepository->getByInvoiceId($invoiceId);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param LicenseCreateRequest $request
     * @param Invoice $invoice
     * @return License|Model
     */
    public function store(LicenseCreateRequest $request, Invoice $invoice)
    {
        return $invoice->licenses()->create($request->validated());
    }
}
