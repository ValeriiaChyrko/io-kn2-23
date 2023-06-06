<?php

namespace App\Repositories;

use App\Models\Transfer as Model;
use Illuminate\Support\Collection;

class TransferRepository extends CoreRepository
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
     * Отримати всі передачі
     *
     * @return Collection
     */
    public function getAllWithRelationsAndPaginate(): Collection
    {
        $columns = [
            'transfers.id',
            'transfers.transfer_date',
            'transfers.transfer_number',
            'from_user.name as from_user_name',
            'to_user.name as to_user_name',
            'transfers.created_at',
            'transfers.file_url',
            'transfers.confirmed',
        ];

        return $this->startConditions()
            ->select($columns)
            ->with('items')    // TODO: withCount
            ->autoJoin(['to_user', 'from_user'])
            ->getFiltered();
    }
}
