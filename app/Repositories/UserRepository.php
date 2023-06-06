<?php

namespace App\Repositories;

use App\Models\User as Model;
use Illuminate\Support\Collection;

class UserRepository extends CoreRepository
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
     * Отримати всіх користувачів
     *
     * @return Collection
     */
    public function getAllWithPaginateAndFiltering(): Collection
    {
        $columns = [
            'users.id as id',
            'users.name as name',
            'users.email as email',
            'users.role_id as role_id',

            'roles.name as role_name'
        ];

        return $this->startConditions()
            ->select($columns)
            ->withCount([
                'items',
                'licenses',
                'sentTransfers',
                'receivedTransfers',
                'repairs'
            ])->autoJoin([
                'role'
            ])->getFiltered();
    }
}
