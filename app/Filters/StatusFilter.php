<?php

namespace App\Filters;

class StatusFilter extends QueryFilter
{
    /**
     * The attributes that can be searched
     *
     * @var string[]
     */
    protected array $searchable = [
        'title',
    ];

    /**
     * The attributes that can be sorted
     *
     * @var string[]
     */
    protected array $sortable = [
        'id' => 'statuses.id',
        'title' => 'statuses.title'
    ];
}
