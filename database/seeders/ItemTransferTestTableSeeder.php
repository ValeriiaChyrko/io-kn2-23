<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Transfer;
use Illuminate\Database\Seeder;

class ItemTransferTestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       // ItemTransfer::factory(200)->create();

        $transfer = Transfer::factory(100)
            ->has(Item::factory()->count(1))
            ->create();
    }
}
