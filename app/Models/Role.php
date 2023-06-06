<?php

namespace App\Models;

use App\Filters\RoleFilter;
use App\Traits\Filterable;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Role
 *
 * @property int $id Record id.
 * @property string $name Role name.
 * @property-read Collection|Permission[] $permissions Collection of role permissions.
 * @mixin Eloquent
 */
class Role extends Model
{
    use Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * @inheritDoc
     */
    protected function getFilterClass(): string
    {
        return RoleFilter::class;
    }

    /**
     * Role permissions, many-to-many relations.
     *
     * @return BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }
}
