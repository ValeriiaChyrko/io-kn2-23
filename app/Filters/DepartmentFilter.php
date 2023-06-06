<?php

namespace App\Filters;

class DepartmentFilter extends QueryFilter
{
    /**
     * Configurations for auto join.
     *
     * @var array
     */
    protected array $joins = [
        'parent' => [
            'table' => 'departments as parent',
            'local' => 'departments.parent_id',
            'foreign' => 'parent.id'
        ]
    ];

    /**
     * The attributes that can be searched
     *
     * @var string[]
     */
    protected array $searchable = [
        'departments.title',
        'parent.title',
    ];

    /**
     * The attributes that can be sorted
     *
     * @var string[]
     */
    protected array $sortable = [
        'id' => 'departments.id',
        'title' => 'departments.title',
        'parent_title' => 'parent.title',
    ];
}
