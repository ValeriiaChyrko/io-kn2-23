<?php

namespace App\Http\Controllers\Api\Item;

use App\Http\Controllers\Controller;
use App\Http\Requests\Item\ItemNumberAvailabilityRequest;
use App\Http\Requests\Item\ItemStatsRequest;
use App\Http\Requests\Item\ItemUpdateRequest;
use App\Models\Item;
use App\Repositories\ItemRepository;
use App\Stats\ItemStats;
use DB;
use Illuminate\Support\Collection;

class ItemController extends Controller
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
     *
     * @param ItemStatsRequest $request
     * @return Collection
     * @throws \App\Exceptions\UnknownStatsGroupByKeyException
     * @throws \App\Exceptions\UnknownStatsJoinedTitleKeyException
     */
    public function stats(ItemStatsRequest $request): Collection
    {
        $config = $request->input();

        $columns = [
            DB::raw('count(*) as count'),
            sprintf('%s as joined_title', ItemStats::getJoinedByKey($config['group_by']))
        ];

        return Item::filter()
            ->autoJoin([
                'type',
                'hardware_model',
                'department',
                'owner',
                'status',
                'invoice'
            ])->select($columns)
            ->groupBy(ItemStats::getColumnByKey($config['group_by']))
            ->get();
    }

    /**
     * Display a listing of the items.
     *
     * @return Collection
     */
    public function index(): Collection
    {
        return $this->itemRepository->getAllWithRelationsAndPaginate();
    }

    /**
     * Display the specified item.
     *
     * @param mixed $id
     * @return Item
     */
    public function show($id): Item
    {
        $item = $this->itemRepository->getForShow($id);
        abort_if(empty($item), 404);

        return $item;
    }

    /**
     * Update the specified item in storage.
     *
     * @param ItemUpdateRequest $request
     * @param Item $item
     * @return Item
     */
    public function update(ItemUpdateRequest $request, Item $item): Item
    {
        $item->update($request->validated());

        return $item;
    }

    /**
     * @param ItemNumberAvailabilityRequest $request
     * @return Collection
     */
    public function numberAvailability(ItemNumberAvailabilityRequest $request): Collection
    {
        return $this->itemRepository->isNumberAvailable($request->validated());
    }

    /**
     * Remove the specified item from storage.
     *
     * @param Item $item
     * @return bool|null
     */
    public function destroy(Item $item): ?bool
    {
        return $item->delete();    //TODO: Return result?
    }
}
