<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Schema;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        $this->truncate();

        $this->call(PermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);

        $this->call(UsersTableSeeder::class);
        $this->call(DepartmentsTableSeeder::class);
        $this->call(StatusesTableSeeder::class);
        $this->call(TypesTableSeeder::class);

        Schema::enableForeignKeyConstraints();
    }

    private function truncate()
    {
        \App\Models\Permission::truncate();
        \App\Models\Role::truncate();

        \App\Models\User::truncate();
        \App\Models\Department::truncate();
        \App\Models\Invoice::truncate();
        \App\Models\Item::truncate();
        \App\Models\License::truncate();
        \App\Models\HardwareModel::truncate();
        \App\Models\Provider::truncate();
        \App\Models\Repair::truncate();
        \App\Models\Status::truncate();
        \App\Models\Transfer::truncate();
        \App\Models\Type::truncate();
        \App\Models\Utilization::truncate();
        \App\Models\Writeoff::truncate();
    }
}
