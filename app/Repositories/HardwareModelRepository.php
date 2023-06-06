<?php

namespace App\Repositories;

use App\Models\HardwareModel as Model;
use Illuminate\Support\Collection;

class HardwareModelRepository extends CoreRepository
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
     * Отримати всі моделі
     *
     * @return Collection
     */
    public function getAllWithPaginateAndFiltering(): Collection
    {
        $columns = ['id', 'title'];

        return $this->startConditions()
            ->select($columns)
            ->withCount('items')
            ->getFiltered();
    }
}
