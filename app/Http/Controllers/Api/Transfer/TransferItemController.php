<?php

namespace App\Http\Controllers\Api\Transfer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Item\ItemCreateRequest;
use App\Models\Item;
use App\Models\Status;
use App\Models\Transfer;
use App\Repositories\ItemRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class TransferItemController extends Controller
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
     * Display a listing of the items that belongs to specified transfer.
     *
     * @param mixed $transferId
     * @return Collection
     */
    public function index($transferId): Collection
    {
        return $this->itemRepository->getByTransferId($transferId);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ItemCreateRequest $request
     * @param Transfer $transfer
     * @return Item|Model
     */
    public function store(ItemCreateRequest $request, Transfer $transfer)
    {
        $item = $request->validated();
        $item['status_id'] = Status::STATUS_IN_USE;

        return $transfer->items()->create($item);
    }
}
