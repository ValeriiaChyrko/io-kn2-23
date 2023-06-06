<?php

namespace App\Filters;

class PermissionFilter extends QueryFilter
{
    /**
     * The attributes that can be searched
     *
     * @var string[]
     */
    protected array $searchable = [
        'permissions.id',
        'permissions.name'
    ];

    /**
     * The attributes that can be sorted
     *
     * @var string[]
     */
    protected array $sortable = [
        'id' => 'permissions.id',
        'name' => 'permissions.name'
    ];
}
