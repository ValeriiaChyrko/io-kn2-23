<?php

namespace App\Repositories;

use App\Models\Type as Model;
use Illuminate\Support\Collection;

class TypeRepository extends CoreRepository
{
    /**
     *  Отримати модель для редагування в адмінці
     *
     * @return class-string
     */
    protected function getModelClass(): string
    {
        return Model::class;
    }

    /**
     * Отримати всі типи
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
