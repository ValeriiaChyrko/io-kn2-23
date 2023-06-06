<?php

namespace App\Repositories;

use App\Models\Repair;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

/**
 * @method Repair|Builder startConditions()
 */
class RepairRepository extends CoreRepository
{
    /**
     * Отримати модель для редагування в адмінці
     *
     * @return class-string
     */
    protected function getModelClass(): string
    {
        return Repair::class;
    }
    /**
     * Отримати модель для редагування в адмінці
     * @param mixed $id
     * @return Repair|null
     */
    public function getForShow($id): ?Repair
    {
        $repair = $this->startConditions()
            ->where('id', $id)
            ->first();

        if(! is_null($repair)) {
            $repair->append(['is_completion_data_editable'])
                ->makeHidden('item');
        }

        return $repair;
    }

    /**
     * Return all repairs that belongs to specified item.
     *
     * @param mixed $itemId Related item id.
     * @return Collection
     */
    public function getByItemId($itemId): Collection
    {
        $columns = [
            'repairs.id as id',
            'repairs.user_id as user_id',
            'repairs.provider_id as provider_id',
            'repairs.start_date as start_date',
            'repairs.end_date as end_date',
            'repairs.is_unrepairable as is_unrepairable',
            'repairs.comment as comment',

            'users.name as user_name',
            'providers.title as provider_title',
        ];

        return $this->startConditions()
            ->select($columns)
            ->autoJoin([
                'user',
                'provider'
            ])->where('item_id', $itemId)
            ->orderBy('repairs.created_at', 'DESC')
            ->get();
    }

    /**
     * Отримати всі записи
     *
     * @return Collection
     */
    public function getAllWithRelationsAndPaginate(): Collection
    {
        $columns = [
            'repairs.id as id',
            'repairs.item_id as item_id',
            'repairs.user_id as user_id',
            'repairs.provider_id as provider_id',
            'repairs.start_date as start_date',
            'repairs.end_date as end_date',
            'repairs.is_unrepairable as is_unrepairable',
            'repairs.comment as comment',

            'items.inventory_number as item_inventory_number',
            'users.name as user_name',
            'providers.title as provider_title',
        ];

        return $this->startConditions()
            ->select($columns)
            ->autoJoin([
                'item',
                'user',
                'provider'
            ])->getFiltered();
    }
}
