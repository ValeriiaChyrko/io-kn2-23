<?php

namespace App\Http\Controllers\Api\Item;

use App\Http\Controllers\Controller;
use App\Http\Requests\Item\ItemPartCreateRequest;
use App\Models\Item;
use App\Models\Status;
use App\Repositories\ItemRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ItemPartController extends Controller
{
    /**
     * @var ItemRepository
     */
    private $itemRepository;

    public function __construct()
    {
        $this->itemRepository = app(ItemRepository::class);
    }

    /**
     * Display a listing of the licenses that belongs to specified item.
     *
     * @param Item $item
     * @return Collection
     */
    public function index(Item $item): Collection
    {
        return $this->itemRepository->getItemParts($item->id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ItemPartCreateRequest $request
     * @param Item $item
     * @return Item|Model
     */
    public function store(ItemPartCreateRequest $request, Item $item)
    {
        $part = $request->validated();
        $part['status_id'] = Status::STATUS_IN_USE;
        $part['owner_id'] = $item->owner_id;
        $part['department_id'] = $item->department_id;
        $part['invoice_id'] = $item->invoice_id;

        return $item->parts()->create($part);
    }
}
