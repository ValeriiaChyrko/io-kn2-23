<?php

namespace App\Http\Controllers\Api\Item;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Repositories\RepairRepository;
use Illuminate\Database\Eloquent\Collection;

class ItemRepairController extends Controller
{
    /**
     * @var RepairRepository
     */
    private $repairRepository;

    public function __construct()
    {
        $this->repairRepository = app(RepairRepository::class);
    }

    /**
     * Display a listing of the repairs that belongs to specified item.
     *
     * @param Item $item
     * @return Collection
     */
    public function index(Item $item): Collection
    {
        return $this->repairRepository->getByItemId($item->id);
    }
}
