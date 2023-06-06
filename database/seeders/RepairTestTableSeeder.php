<?php

namespace Database\Seeders;

use App\Models\Repair;
use Illuminate\Database\Seeder;

class RepairTestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Repair::factory(200)->create();
    }
}
