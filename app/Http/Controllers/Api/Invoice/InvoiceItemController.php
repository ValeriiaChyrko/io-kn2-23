<?php

namespace App\Http\Controllers\Api\Invoice;

use App\Http\Controllers\Controller;
use App\Http\Requests\Item\ItemCreateRequest;
use App\Models\Invoice;
use App\Models\Item;
use App\Models\Status;
use App\Repositories\ItemRepository;
use Illuminate\Database\Eloquent\Model;

class InvoiceItemController extends Controller
{
    /**
     * @var ItemRepository
     */
    private ItemRepository $itemRepository;

    public function __construct()
    {
        $this->itemRepository = app(ItemRepository::class);
    }

    /**
     * Display a listing of the items that belongs to specified invoice.
     *
     * @param mixed $invoiceId
     * @return array
     */
    public function index($invoiceId)
    {
        return $this->itemRepository->getByInvoiceId($invoiceId);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ItemCreateRequest $request
     * @param Invoice $invoice
     * @return Item|Model
     */
    public function store(ItemCreateRequest $request, Invoice $invoice)
    {
        $item = $request->validated();
        $item['status_id'] = Status::STATUS_IN_USE;

        return $invoice->items()->create($item);
    }
}
