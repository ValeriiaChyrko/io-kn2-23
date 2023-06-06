<?php

namespace App\Filters;

class ItemFilter extends QueryFilter
{
    /**
     * Available custom scopes.
     *
     * @var array
     */
    protected array $scopes = [
        'onlyParentable',
        'onlyRepairable',
        'onlyTransferable'
    ];

    /**
     * The attributes that can be filtered.
     *
     * @var string[]
     */
    protected array $filterable = [
        'items.invoice_id',
        'items.type_id',
        'items.hardware_model_id',
        'items.invoice_id',
        'items.owner_id',
        'items.department_id',
        'items.price'
    ];

    /**
     * Configurations for auto join.
     *
     * @var array
     */
    protected array $joins = [
        'type' => [
            'table' => 'types',
            'local' => 'items.type_id',
            'foreign' => 'types.id'
        ],
        'hardware_model' => [
            'table' => 'hardware_models',
            'local' => 'items.hardware_model_id',
            'foreign' => 'hardware_models.id'
        ],
        'department' => [
            'table' => 'departments',
            'local' => 'items.department_id',
            'foreign' => 'departments.id'
        ],
        'owner' => [
            'table' => 'users as owner',
            'local' => 'items.owner_id',
            'foreign' => 'owner.id'
        ],
        'status' => [
            'table' => 'statuses',
            'local' => 'items.status_id',
            'foreign' => 'statuses.id'
        ],
        'invoice' => [
            'table' => 'invoices',
            'local' => 'items.invoice_id',
            'foreign' => 'invoices.id'
        ],
        'parent_item' => [
            'table' => 'items as parent_item',
            'local' => 'items.part_of',
            'foreign' => 'parent_item.id'
        ],
    ];

    /**
     * The attributes that can be searched
     *
     * @var string[]
     */
    protected array $searchable = [
        'items.id',
        'items.inventory_number',

        'parent_item.inventory_number',
        'types.title',
        'hardware_models.title',
        'departments.title',
        'owner.name',
        'statuses.title',
        'invoices.number',
    ];

    /**
     * The attributes that can be sorted
     *
     * @var string[]
     */
    protected array $sortable = [
        'id' => 'items.id',
        'inventory_number' => 'items.inventory_number',

        'parent_number' => 'parent_item.inventory_number',
        'type_title' => 'types.title',
        'hardware_model_title' => 'hardware_models.title',
        'department_title' => 'departments.title',
        'owner_name' => 'owner.name',
        'status_title' => 'statuses.title',
        'invoice_number' => 'invoices.number',
    ];

    /**
     * Get only parentable items.
     */
    protected function onlyParentableScope()
    {
        $this->builder->onlyParentable();
    }

    /**
     * Get only repairable items.
     */
    protected function onlyRepairableScope()
    {
        $this->builder->onlyRepairable();
    }

    /**
     * Get only transferable items.
     */
    protected function onlyTransferableScope()
    {
        $this->builder->onlyTransferable();
    }
}
