<?php

namespace App\Filters;

class InvoiceFilter extends QueryFilter
{
    /**
     * Configurations for auto join.
     *
     * @var array
     */
    protected array $joins = [
        'provider' => [
            'table' => 'providers',
            'local' => 'invoices.provider_id',
            'foreign' => 'providers.id'
        ],
        'receiver' => [
            'table' => 'users as receiver',
            'local' => 'invoices.receiver_id',
            'foreign' => 'receiver.id'
        ]
    ];

    /**
     * The attributes that can be searched
     *
     * @var string[]
     */
    protected array $searchable = [
        'invoices.id',
        'invoices.number',
        'invoices.date',
        'invoices.total_sum',

        'providers.title',
        'receiver.name'
    ];

    /**
     * The attributes that can be sorted
     *
     * @var string[]
     */
    protected array $sortable = [
        'id' => 'invoices.id',
        'number' => 'invoices.number',
        'date' => 'invoices.date',
        'total_sum' => 'invoices.total_sum',
        'created_at' => 'invoices.created_at',

        'provider_title' => 'providers.title',
        'receiver_name' => 'receiver.name'
    ];
}
