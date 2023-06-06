<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Transfer;
use Illuminate\Database\Seeder;

class ItemTestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = Item::factory(200)->create();
        /*$transfer = Transfer::factory(200)
            ->count(1)
            ->hasAttached($items)
            ->create();*/
    }
}
