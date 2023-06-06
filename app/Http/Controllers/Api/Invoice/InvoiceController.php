<?php

namespace App\Http\Controllers\Api\Invoice;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invoice\InvoiceCreateRequest;
use App\Http\Requests\Invoice\InvoiceUpdateRequest;
use App\Models\Invoice;
use App\Repositories\InvoiceRepository;
use Illuminate\Support\Collection;

class InvoiceController extends Controller
{
    /**
     * @var InvoiceRepository
     */
    private $invoiceRepository;

    public function __construct()
    {
        $this->invoiceRepository = app(InvoiceRepository::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Collection
     */
    public function index(): Collection
    {
        return $this->invoiceRepository->getAllWithRelationsAndPaginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param InvoiceCreateRequest $request
     * @return Invoice
     */
    public function store(InvoiceCreateRequest $request): Invoice
    {
        $invoice = $request->validated();
        $invoice['total_sum'] = 0;
        $invoice['file_url'] = $request->file('file')->store('invoice', 'private');

        return Invoice::create($invoice);
    }

    /**
     * Display the specified resource.
     *
     * @param Invoice $invoice
     * @return Invoice
     */
    public function show(Invoice $invoice): Invoice
    {
        return $invoice;    // TODO: Load joined fields (e.g. provider_title)
    }

    /**
     * Update the specified resource in storage.
     *
     * @param InvoiceUpdateRequest $request
     * @param Invoice $invoice
     * @return Invoice
     */
    public function update(InvoiceUpdateRequest $request, Invoice $invoice): Invoice
    {
        $invoice->update($request->validated());

        return $invoice;
    }
}
