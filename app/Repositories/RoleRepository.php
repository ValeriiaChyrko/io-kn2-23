<?php

namespace App\Repositories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

/**
 * @method Role|Builder startConditions()
 */
class RoleRepository extends CoreRepository
{
    /**
     * Get the model class-string.
     *
     * @return class-string
     */
    protected function getModelClass(): string
    {
        return Role::class;
    }

    /**
     * Get all with pagination.
     *
     * @return Collection
     */
    public function paginate(): Collection
    {
        $columns = [
            'roles.id',
            'roles.name'
        ];

        return $this->startConditions()
            ->select($columns)
            ->getFiltered();
    }

    /**
     * Find role by id
     *
     * @param mixed $id Role id
     * @return Role|null
     */
    public function find($id): ?Role
    {
        $columns = [
            'id',
            'name'
        ];

        return $this->startConditions()
            ->select($columns)
            ->with('permissions')
            ->find($id);
    }
}
