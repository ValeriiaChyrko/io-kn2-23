<?php

namespace App\Repositories;

use App\Models\Status as Model;
use Illuminate\Support\Collection;

class StatusRepository extends CoreRepository
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
     * Отримати всі відділи
     *
     * @return Collection
     */
    public function getAllWithPaginateAndFiltering(): Collection
    {
        $columns = ['id', 'title'];

        return $this->startConditions()
            ->select($columns)
            ->getFiltered();

    }
}
