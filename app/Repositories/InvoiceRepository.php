<?php

namespace App\Repositories;

use App\Models\Invoice as Model;
use Illuminate\Support\Collection;

class InvoiceRepository extends CoreRepository
{
    /**
     * Отримати модель для редагування в адмінці
     *
     * @return class-string
     */
    protected function getModelClass(): string
    {
        return Model::class;
    }

    /**
     * Отримати всі відділи з батьківськими категоріями
     *
     * @return Collection
     */
    public function getAllWithRelationsAndPaginate(): Collection
    {
        $columns = [
            'invoices.id as id',
            'invoices.number as number',
            'invoices.receiver_id as receiver_id',
            'invoices.date as date',
            'invoices.total_sum as total_sum',
            'invoices.created_at as created_at',
            'invoices.approved as approved',

            'providers.title as provider_title',
            'receiver.name as receiver_name'
        ];

        return $this->startConditions()
            ->select($columns)
            ->autoJoin(['provider', 'receiver'])
            ->getFiltered();
    }
}
