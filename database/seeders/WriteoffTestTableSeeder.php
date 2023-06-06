<?php

namespace Database\Seeders;

use App\Models\Writeoff;
use Illuminate\Database\Seeder;

class WriteoffTestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Writeoff::factory(200)->create();
    }
}
