<?php

namespace App\Filters;

class RoleFilter extends QueryFilter
{
    /**
     * The attributes that can be searched
     *
     * @var string[]
     */
    protected array $searchable = [
        'roles.id',
        'roles.name'
    ];

    /**
     * The attributes that can be sorted
     *
     * @var string[]
     */
    protected array $sortable = [
        'id' => 'roles.id',
        'name' => 'roles.name'
    ];
}
