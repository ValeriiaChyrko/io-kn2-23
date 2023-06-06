<?php

namespace App\Filters;

class LicenseFilter extends QueryFilter
{
    /**
     * Configurations for auto join.
     *
     * @var array
     */
    protected array $joins = [
        'item' => [
            'table' => 'items',
            'local' => 'licenses.item_id',
            'foreign' => 'items.id'
        ],
        'software_model' => [
            'table' => 'software_models',
            'local' => 'licenses.software_model_id',
            'foreign' => 'software_models.id'
        ],
        'invoice' => [
            'table' => 'invoices',
            'local' => 'licenses.invoice_id',
            'foreign' => 'invoices.id'
        ],
        'owner' => [
            'table' => 'users as owner',
            'local' => 'licenses.owner_id',
            'foreign' => 'owner.id'
        ]
    ];

    /**
     * The attributes that can be searched
     *
     * @var string[]
     */
    protected array $searchable = [
        'licenses.id',
        'licenses.price',

        'software_models.title',
        'items.inventory_number',
        'invoices.number',
        'owner.name',
    ];

    /**
     * The attributes that can be sorted
     *
     * @var string[]
     */
    protected array $sortable = [
        'id' => 'licenses.id',
        'price' => 'licenses.price',

        'software_model_title' => 'software_models.title',
        'item_inventory_number' => 'items.inventory_number',
        'invoice_number' => 'invoices.number',
        'owner_name' => 'owner.name'
    ];
}
