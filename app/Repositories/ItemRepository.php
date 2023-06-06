<?php

namespace App\Repositories;

use App\Models\Item;
use App\Models\Transfer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

/**
 * @method Item|Builder startConditions()
 */
class ItemRepository extends CoreRepository
{
    /**
     * Отримати модель для редагування в адмінці
     *
     * @return class-string
     */
    protected function getModelClass(): string
    {
        return Item::class;
    }

    /**
     * Check is item inventory numbers is available.
     *
     * @param array $pairs
     * @return Collection
     */
    public function isNumberAvailable(array $pairs): Collection
    {
        /**
         * @var \Illuminate\Database\Eloquent\Collection<Item> $items
         */
        $items = $this->startConditions()
            ->where(function (Builder $query) use ($pairs) {
                foreach ($pairs as $pair) {    // $pair is an array with 'number' and 'ignoreId' keys
                    $query->orWhere(function(Builder $query) use ($pair) {
                        $query->where('inventory_number', $pair['number'])
                        ->when(!is_null($pair['ignoreId'] ?? null), function ($query) use ($pair) {
                            $query->where('id', '!=', $pair['ignoreId']);
                        });
                    });
                }
            })
            ->withTrashed()
            ->get();

        $availability = collect();
        foreach ($pairs as $pair) {
            $number = $pair['number'];
            /**
             * @var Item $item
             */
            $item = $items->filter(function(Item $item) use ($number) {
                return $item->inventory_number == $number;
            })->first();

            $availability->push([
                'number' => $number,
                'available' => empty($item),
                'id' => $item->id ?? null
            ]);
        }

        return $availability;
    }

    /**
     * Find item by id for show
     *
     * @param $id
     * @return Item|null
     */
    public function getForShow($id): ?Item
    {
        $columns = [
            'items.id',
            'items.type_id',
            'items.hardware_model_id',
            'items.department_id',
            'items.owner_id',
            'items.status_id',
            'items.inventory_number',
            'items.price',
            'items.invoice_id',
            'items.has_parts',
            'items.part_of',
            'items.comment',
            'items.created_at',
            'items.updated_at',


            'types.title as type_title',
            'hardware_models.title as hardware_model_title',
            'departments.title as department_title',
            'owner.name as owner_name',
            'statuses.title as status_title',
            'invoices.number as invoice_number',
            'invoices.date as invoice_date',
            'invoices.approved as invoice_approved'
        ];

        return $this->startConditions()
            ->select($columns)
            ->autoJoin([
                'type',
                'hardware_model',
                'department',
                'owner',
                'status',
                'invoice'
            ])->withCount('parts')
            ->withCount('licenses')
            ->where('items.id', $id)
            ->first();
    }

    public function getItemParts($itemId)
    {
        $columns = [
            'items.id',
            'items.type_id',
            'items.hardware_model_id',
            'items.department_id',
            'items.owner_id',
            'items.status_id',
            'items.inventory_number',
            'items.price',
            'items.invoice_id',
            'items.created_at',
            'items.updated_at',


            'types.title as type_title',
            'hardware_models.title as hardware_model_title',
            'departments.title as department_title',
            'owner.name as owner_name',
            'statuses.title as status_title',
            'invoices.number as invoice_number',
            'invoices.date as invoice_date',
            'invoices.approved as invoice_approved'
        ];

        return $this->startConditions()
            ->select($columns)
            ->autoJoin([
                'type',
                'hardware_model',
                'department',
                'owner',
                'status',
                'invoice'
            ])->where('items.part_of', $itemId)
            ->get();
    }

    /**
     * Get collection of items that belongs to specified invoice
     *
     * @param mixed $invoiceId Invoice id
     * @return mixed
     */
    public function getByInvoiceId($invoiceId): Collection
    {
        $columns = [
            'items.id',
            'items.type_id',
            'items.hardware_model_id',
            'items.department_id',
            'items.owner_id',
            'items.inventory_number',
            'items.price',
            'items.part_of',


            'types.title as type_title',
            'hardware_models.title as hardware_model_title',
            'departments.title as department_title',
            'owner.name as owner_name',
            'statuses.title as status_title',
            'invoices.date as invoice_date',
            'invoices.approved as invoice_approved'
        ];

        $collectionOfNonPartialItems = $this->startConditions()
            ->autoJoin([
                'invoice',
                'type',
                'hardware_model',
                'department',
                'owner',
                'status'
            ])->select($columns)
            ->withCount('parts')
            ->withCount('licenses')
            ->where('invoice_id', $invoiceId)
            ->whereNull('part_of')
            ->get();


        $columnsForParts = [
            'items.id',
            'items.type_id',
            'items.hardware_model_id',
            'items.department_id',
            'items.owner_id',
            'items.inventory_number',
            'items.price',
            'items.part_of',


            'types.title as type_title',
            'hardware_models.title as hardware_model_title',
            'departments.title as department_title',
            'owner.name as owner_name',
            'statuses.title as status_title',
        ];

        $collectionOfParts = $this->startConditions()
            ->autoJoin([
                'type',
                'hardware_model',
                'department',
                'owner',
                'status',
                'parent_item'
            ])->select($columnsForParts)
            ->where('items.invoice_id', $invoiceId)
            ->whereNotNull('items.part_of')
            ->where('parent_item.invoice_id', '!=', $invoiceId)
            ->get();

        return $collectionOfNonPartialItems->merge($collectionOfParts)->sortBy('id')->values();
    }

    /**
     * Get collection of items that belongs to specified transfer
     *
     * @param mixed $transferId Transfer id
     * @return mixed
     */
    public function getByTransferId($transferId)
    {
        $columns = [
            'items.id',
            'items.type_id',
            'items.hardware_model_id',
            'items.department_id',
            'items.owner_id',
            'items.inventory_number',
            'items.price',
            'items.part_of',


            'types.title as type_title',
            'hardware_models.title as hardware_model_title',
            'departments.title as department_title',
            'owner.name as owner_name',
            'statuses.title as status_title',

        ];

        $collectionOfNonPartialItems = Transfer::find($transferId)->items()
            ->select($columns)
            ->autoJoin([
                'type',
                'hardware_model',
                'department',
                'owner',
                'status'
            ])->withCount('parts')
            ->withCount('licenses')
            ->get();

        return $collectionOfNonPartialItems;
    }

    /**
     * Отримати всі позиції користувача з батьківськими категоріями
     *
     * @param $userId
     * @return Collection
     */
    public function getAllUserItemsWithRelationsAndPaginate($userId): Collection
    {
        $columns = [
            'items.id',
            'items.inventory_number',
            'items.comment',
            'items.has_parts',
            'items.owner_id',
            'items.status_id',

            'parent_item.inventory_number as parent_number',
            'types.title as type_title',
            'hardware_models.title as hardware_model_title',
            'departments.title as department_title',
            'owner.name as owner_name',
            'statuses.title as status_title',
            'invoices.number as invoice_number',
            'invoices.date as invoice_date',
            'invoices.approved as invoice_approved'
        ];

        return $this->startConditions()
            ->select($columns)
            ->autoJoin([
                'type',
                'hardware_model',
                'department',
                'owner',
                'status',
                'invoice',
                'parent_item'
            ])->withCount(['parts', 'licenses'])
            ->where('items.owner_id', '=', $userId)
            ->getFiltered();
    }

    /**
     * Отримати всі відділи з батьківськими категоріями
     *
     * @return Collection
     */
    public function getAllWithRelationsAndPaginate(): Collection
    {
        $columns = [
            'items.id',
            'items.type_id',
            'items.hardware_model_id',
            'items.department_id',
            'items.owner_id',
            'items.status_id',
            'items.inventory_number',
            'items.price',
            'items.invoice_id',
            'items.has_parts',
            'items.part_of',
            'items.comment',
            'items.created_at',
            'items.updated_at',

            'parent_item.inventory_number as parent_number',
            'types.title as type_title',
            'hardware_models.title as hardware_model_title',
            'departments.title as department_title',
            'owner.name as owner_name',
            'statuses.title as status_title',
            'invoices.number as invoice_number',
            'invoices.date as invoice_date',
            'invoices.approved as invoice_approved'
        ];

        return $this->startConditions()
            ->select($columns)
            ->autoJoin([
                'type',
                'hardware_model',
                'department',
                'owner',
                'status',
                'invoice',
                'parent_item'
            ])->withCount(['parts', 'licenses'])
            ->whereNull('items.part_of')
            ->getFiltered();
    }
}
