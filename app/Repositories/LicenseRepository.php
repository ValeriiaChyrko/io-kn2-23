<?php

namespace App\Repositories;

use App\Models\License;
use App\Models\Transfer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

/**
 * @method License|Builder startConditions()
 */
class LicenseRepository extends CoreRepository
{
    /**
     * Отримати модель для редагування в адмінці
     *
     * @return class-string
     */
    protected function getModelClass(): string
    {
        return License::class;
    }

    /**
     * Отримати всі відділи з батьківськими категоріями
     *
     * @return Collection
     */
    public function getAllWithRelationsAndPaginate(): Collection
    {
        $columns = [
            'licenses.id as id',
            'licenses.price as price',

            'software_models.title as software_model_title',
            'items.inventory_number as item_inventory_number',
            'invoices.number as invoice_number',
            'owner.name as owner_name',
        ];

        return $this->startConditions()
            ->select($columns)
            ->autoJoin([
                'software_model',
                'item',
                'invoice',
                'owner'
            ])->getFiltered();
    }

    /**
     * Return all licenses that belongs to specified item.
     *
     * @param mixed $itemId Related item id.
     * @return Collection
     */
    public function getByItemId($itemId): Collection
    {
        $columns = [
            'licenses.id',
            'licenses.software_model_id',
            'licenses.price',
            'licenses.item_id',
            'licenses.owner_id',
            'licenses.end_date',

            'software_models.title as software_model_title',
            'items.inventory_number as item_inventory_number',
            'owner.name as owner_name',
        ];

        return $this->startConditions()
            ->select($columns)
            ->autoJoin([
                'software_model',
                'item',
                'owner'
            ])->where('licenses.item_id', $itemId)
            ->get();
    }

    /**
     * Returns collection of licenses that belongs to specified invoice
     *
     * @param mixed $invoiceId
     * @return Collection
     */
    public function getByInvoiceId($invoiceId): Collection
    {
        $columns = [
            'licenses.id',
            'licenses.software_model_id',
            'licenses.price',
            'licenses.item_id',
            'licenses.owner_id',
            'licenses.end_date',

            'software_models.title as software_model_title',
            'items.inventory_number as item_inventory_number',
            'owner.name as owner_name',
        ];

        return $this->startConditions()
            ->select($columns)
            ->autoJoin([
                'software_model',
                'item',
                'owner'
            ])->where('licenses.invoice_id', $invoiceId)
            ->where(function ($query) use ($invoiceId) {
                $query
                    ->where('items.invoice_id', '!=', $invoiceId)
                    ->orWhereNull('licenses.item_id');
            })->orderBy('licenses.id')
            ->get();
    }

    /**
     * Returns collection of licenses that belongs to specified transfer
     *
     * @param mixed $transferId
     * @return Collection
     */
    public function getByTransferId($transferId): Collection
    {
        $columns = [
            'licenses.id',
            'licenses.software_model_id',
            'licenses.price',
            'licenses.item_id',
            'licenses.owner_id',
            'licenses.end_date',

            'software_models.title as software_model_title',
            'items.inventory_number as item_inventory_number',
            'owner.name as owner_name',
        ];

        return Transfer::find($transferId)->items()
            ->select($columns)
            ->autoJoin([
                'software_model',
                'item',
                'owner'
            ])->get();
    }
}
