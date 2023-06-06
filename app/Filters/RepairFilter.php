<?php

namespace App\Filters;

class RepairFilter extends QueryFilter
{
    /**
     * Configurations for auto join.
     *
     * @var array
     */
    protected array $joins = [
        'item' => [
            'table' => 'items',
            'local' => 'repairs.item_id',
            'foreign' => 'items.id'
        ],
        'provider' => [
            'table' => 'providers',
            'local' => 'repairs.provider_id',
            'foreign' => 'providers.id'
        ],
        'user' => [
            'table' => 'users',
            'local' => 'repairs.user_id',
            'foreign' => 'users.id'
        ]
    ];

    /**
     * The attributes that can be searched
     *
     * @var string[]
     */
    protected array $searchable = [
        'repairs.id',
        'repairs.start_date',
        'repairs.end_date',

        'items.inventory_number',
        'users.name',
        'providers.title',
    ];

    /**
     * The attributes that can be sorted
     *
     * @var string[]
     */
    protected array $sortable = [
        'id' => 'repairs.id',
        'start_date' => 'repairs.start_date',
        'end_date' => 'repairs.end_date',

        'item_inventory_number' => 'items.inventory_number',
        'user_name' => 'users.name',
        'provider_title' => 'providers.title'
    ];
}
