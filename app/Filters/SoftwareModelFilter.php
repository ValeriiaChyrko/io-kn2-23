<?php

namespace App\Filters;

class SoftwareModelFilter extends QueryFilter
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
        'id' => 'software_models.id',
        'title' => 'software_models.title'
    ];
}
