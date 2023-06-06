<?php

namespace App\Models;

use App\Filters\PermissionFilter;
use App\Traits\Filterable;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Permission
 *
 * @property int $id Record id.
 * @property string $name Permission name.
 * @property-read Collection|Role[] $permissions Collection of permission roles.
 * @mixin Eloquent
 */
class Permission extends Model
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
     * All available permissions.
     *
     * @var string[]
     */
    public static array $permissions = [
        'view-departments',
        'view-invoices',
        'view-items',
        'view-licenses',
        'view-transfers',
        'view-hardware-models',
        'view-software-models',
        'view-providers',
        'view-statuses',
        'view-types',
        'view-users',
        'view-repairs',
        'view-stats',
        'view-roles',
        'view-permissions',

        'edit-approved-invoice',
        'approve-invoice'
    ];

    /**
     * @inheritDoc
     */
    protected function getFilterClass(): string
    {
        return PermissionFilter::class;
    }

    /**
     * Permission roles, many-to-many relations.
     *
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }
}
