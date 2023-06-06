<?php

namespace App\Repositories;

use App\Models\Provider as Model;
use Illuminate\Support\Collection;

class ProviderRepository extends CoreRepository
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
     * Отримати всі відділи
     *
     * @return Collection
     */
    public function getAllWithPaginateAndFiltering(): Collection
    {
        $columns = ['id', 'title', 'address', 'phone'];

        return $this->startConditions()
            ->select($columns)
            ->withCount(['invoices', 'repairs'])
            ->getFiltered();
    }
}
