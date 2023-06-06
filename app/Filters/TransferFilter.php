<?php

namespace App\Filters;

class TransferFilter extends QueryFilter
{
    /**
     * Configurations for auto join.
     *
     * @var array
     */
    protected array $joins = [
        'to_user' => [
            'table' => 'users as to_user',
            'local' => 'transfers.to_user_id',
            'foreign' => 'to_user.id'
        ],
        'from_user' => [
            'table' => 'users as from_user',
            'local' => 'transfers.from_user_id',
            'foreign' => 'from_user.id'
        ]
    ];

    /**
     * The attributes that can be searched
     *
     * @var string[]
     */
    protected array $searchable = [
        'transfer_date',
        'from_user.name',
        'to_user.name',
        'confirmed'
    ];

    /**
     * The attributes that can be sorted
     *
     * @var string[]
     */
    protected array $sortable = [
        'id' => 'transfers.id',
        'transfer_date' => 'transfers.transfer_date',
        'from_user_name' => 'from_user.name',
        'to_user_name' => 'to_user.name',
        'confirmed' => 'transfers.confirmed'
    ];
}
