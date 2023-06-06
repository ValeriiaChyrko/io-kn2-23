<?php

namespace App\Repositories;

use App\Models\Department as Model;
use Illuminate\Support\Collection;

class DepartmentRepository extends CoreRepository
{
    /**
     * Отримати модель для редагування в адмінці
     *
     * @return string
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
    public function getAllWithParents(): Collection
    {
        $columns = [
            'departments.id as id',
            'departments.title as title',
            'departments.parent_id as parent_id',

            'parent.title as parent_title'
        ];

        return $this->startConditions()
            ->select($columns)
            ->withCount(['children', 'items'])
            ->autoJoin(['parent'])
            ->getFiltered();
    }
}
