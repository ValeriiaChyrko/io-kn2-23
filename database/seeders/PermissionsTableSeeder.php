<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'view-departments',
            'view-invoices',
            'view-items',
            'view-licenses',
            'view-transfers',
            'view-hardware-models',
            'view-software-models',
            'view-providers',
            'view-statuses',
            'view-types',
            'view-users',
            'view-repairs',
            'view-stats',
            'view-roles',
            'view-permissions',

            'edit-approved-invoice',
            'approve-invoice'
        ];


        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission
            ]);
        }
    }
}
