<?php

namespace Database\Seeders;

use App\Models\Transfer;
use Illuminate\Database\Seeder;

class TransferTestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Transfer::factory(200)->create();
    }
}
