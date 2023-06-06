<?php

namespace Database\Seeders;

use App\Models\HardwareModel;
use Illuminate\Database\Seeder;

class HardwareModelTestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HardwareModel::factory(200)->create();
    }
}
