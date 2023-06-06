<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

/**
 * @method Permission|Builder startConditions()
 */
class PermissionRepository extends CoreRepository
{
    /**
     * Get the model class-string.
     *
     * @return class-string
     */
    protected function getModelClass(): string
    {
        return Permission::class;
    }

    /**
     * Get all with pagination.
     *
     * @return Collection
     */
    public function paginate(): Collection
    {
        $columns = [
            'permissions.id',
            'permissions.name'
        ];

        return $this->startConditions()
            ->select($columns)
            ->getFiltered();
    }

    /**
     * Find permission by id.
     *
     * @param mixed $id Permission id
     * @return Role|null
     */
    public function find($id): ?Permission
    {
        $columns = [
            'id',
            'name'
        ];

        return $this->startConditions()
            ->select($columns)
            ->find($id);
    }
}
