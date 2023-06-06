<?php

namespace Database\Seeders;

use App\Models\SoftwareModel;
use Illuminate\Database\Seeder;

class SoftwareModelTestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SoftwareModel::factory(25)->create();
    }
}
