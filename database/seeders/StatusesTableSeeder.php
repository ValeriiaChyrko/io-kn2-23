<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
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
                'id' => Status::STATUS_IN_USE,
                'title' => 'Встановлено',
            ],
            [
                'id' => Status::STATUS_TRANSFERRING,
                'title' => 'Передається',
            ],
            [
                'id' => Status::STATUS_REPAIRING,
                'title' => 'В ремонті',
            ],
            [
                'id' => Status::STATUS_UNREPAIRABLE,
                'title' => 'Не підлягає ремонту',
            ],
            [
                'id' => Status::STATUS_WRITTEN_OFF,
                'title' => 'Списано',
            ],
            [
                'id' => Status::STATUS_UTILIZED,
                'title' => 'Утилізовано',
            ]
        ];
        Status::insert($data);
    }
}
