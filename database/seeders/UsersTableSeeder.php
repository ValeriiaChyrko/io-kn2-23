<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $suRoleId = Role::where('name', 'su')->first()->id;

        $data = [
            [
                'name' => 'Ігор Ростиславович Зубенко',
                'email' => 'admin@oa.edu.ua',
                'role_id' => $suRoleId,
                'avatar' => 'https://lh5.googleusercontent.com/-d_60A16k1Qo/AAAAAAAAAAI/AAAAAAAAAAA/AMZuuclJXsCCfufd8iQ89JnaZofl6R7jGw/photo.jpg',
                'google_id' => '116474708955860264235',
            ],
            [
                'name' => 'Максим Луцюк',
                'email' => 'maksym.lutsiuk@oa.edu.ua',
                'role_id' => $suRoleId,
                'avatar' => 'https://lh3.googleusercontent.com/a-/AOh14GhGE2p3Gw2dNHiv2Zzoz0JG0gU2jhc0N2_Kn12a=s96-c',
                'google_id' => '111286508273575218524',
            ],
            [
                'name' => 'Інформаційно-технічний центр',
                'email' => 'tzn@oa.edu.ua',
                'role_id' => $suRoleId,
                'avatar' => '',
                'google_id' => '',
            ],
            [
                'name' => 'Олег Серко',
                'email' => 'oleh.serko@oa.edu.ua',
                'role_id' => $suRoleId,
                'avatar' => '',
                'google_id' => '',
            ],
        ];
        User::insert($data);
    }
}
