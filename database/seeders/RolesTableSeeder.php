<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'user'
            ],
            [
                'name' => 'manager'
            ],
            [
                'name' => 'su'
            ],
        ];
        Role::insert($data);

        foreach ($data as $role) {
            Role::firstOrCreate($role);
        }
    }
}
