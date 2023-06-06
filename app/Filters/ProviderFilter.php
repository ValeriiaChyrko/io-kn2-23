<?php

namespace App\Filters;

class ProviderFilter extends QueryFilter
{
    /**
     * The attributes that can be searched
     *
     * @var string[]
     */
    protected array $searchable = [
        'title',
        'address',
        'phone',
    ];

    /**
     * The attributes that can be searched
     *
     * @var string[]
     */
    protected array $sortable = [
        'id' => 'providers.id',
        'title' => 'providers.title',
        'address' => 'providers.address',
        'phone' => 'providers.phone'
    ];
}
