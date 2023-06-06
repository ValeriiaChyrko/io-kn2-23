<?php

namespace Database\Seeders;

use App\Models\Utilization;
use Illuminate\Database\Seeder;

class UtilizationTestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Utilization::factory(200)->create();
    }
}
