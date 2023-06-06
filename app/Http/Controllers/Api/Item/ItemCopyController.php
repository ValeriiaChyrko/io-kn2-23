<?php

namespace App\Http\Controllers\Api\Item;

use App\Http\Controllers\Controller;
use App\Http\Requests\Item\ItemCopyRequest;
use App\Models\Item;
use DB;
use Illuminate\Http\JsonResponse;
use Throwable;

class ItemCopyController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param ItemCopyRequest $request
     * @param Item $item
     * @return JsonResponse
     * @throws Throwable
     */
    public function __invoke(ItemCopyRequest $request, Item $item): JsonResponse
    {
        $config = $request->validated();
        $itemParts = $this->preparePartsArray($item);
        $itemLicenses = $this->prepareLicensesArray($item);
        $items = collect();

        return DB::transaction(function () use ($itemLicenses, $itemParts, $item, $items, $config) {
            if ($config['useRange']) {
                foreach ($config['numbersRange'] as $number) {
                    $items->push($this->createCopy($item, $itemParts, $itemLicenses, $number));
                }
            } else {
                for ($i = 1; $i <= $config['count']; $i++) {
                    $items->push($this->createCopy($item, $itemParts, $itemLicenses, null));
                }
            }

            return response()->json($items);
        });
    }

    /**
     * Creates copy of item with parts and licenses.
     *
     * @param Item $item Item to copy
     * @param array $parts Item parts
     * @param array $licenses Items licenses
     * @param string|null $inventoryNumber Item inventory number
     * @return Item
     */
    private function createCopy(Item $item, array $parts, array $licenses, ?string $inventoryNumber): Item
    {
        $copy = $item->replicate();
        $copy->inventory_number = $inventoryNumber;
        $copy->save();

        $copy->parts()->createMany($parts);
        $copy->licenses()->createMany($licenses);

        return $copy;
    }

    /**
     * Generate array of specified field from collection of item parts.
     *
     * @param Item $item
     * @return array
     */
    private function preparePartsArray(Item $item): array
    {
        $parts = $item->parts()->where('invoice_id', $item->invoice_id)->get();

        return $parts->map->only([
            'type_id',
            'hardware_model_id',
            'department_id',
            'owner_id',
            'status_id',
            'price',
            'invoice_id'
        ])->toArray();
    }

    /**
     * Generate array of specified field from collection of item licenses.
     *
     * @param Item $item
     * @return array
     */
    private function prepareLicensesArray(Item $item): array
    {
        $licenses = $item->licenses()->where('invoice_id', $item->invoice_id)->get();

        return $licenses->map->only([
            'software_model_id',
            'price',
            'invoice_id',
            'owner_id',
            'department_id',
            'end_date'
        ])->toArray();
    }
}
