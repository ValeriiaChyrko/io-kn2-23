<?php

namespace App\Filters;

class UserFilter extends QueryFilter
{
    /**
     * Configurations for auto join.
     *
     * @var array
     */
    protected array $joins = [
        'role' => [
            'table' => 'roles',
            'local' => 'users.role_id',
            'foreign' => 'roles.id'
        ]
    ];

    /**
     * The attributes that can be searched
     *
     * @var string[]
     */
    protected array $searchable = [
        'users.id',
        'users.name',
        'users.email',
        'roles.name',
    ];

    /**
     * The attributes that can be sorted
     *
     * @var string[]
     */
    protected array $sortable = [
        'id' => 'users.id',
        'name' => 'users.name',
        'email' => 'users.email',
        'role_name' => 'roles.name'
    ];
}
