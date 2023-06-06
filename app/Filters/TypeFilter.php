<?php

namespace App\Filters;

class TypeFilter extends QueryFilter
{
    /**
     * The attributes that can be searched
     *
     * @var string[]
     */
    protected array $searchable = [
        'title'
    ];

    /**
     * The attributes that can be sorted
     *
     * @var string[]
     */
    protected array $sortable = [
        'id' => 'types.id',
        'title' => 'types.titles'
    ];
}
