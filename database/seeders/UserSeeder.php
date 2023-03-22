<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
//        User::factory()->count(10)->create();
        User::create(
            [
                'firstname' => 'Nick',
                'lastname' => 'Bevers',
                'email' => 'nick.bevers9@gmail.com',
                'password' => bcrypt('test1234'),
                'user_type' => 'admin',
            ]
        );

        User::create(
            [
                'firstname' => 'Ismail',
                'lastname' => 'El Ghamri',
                'email' => 'ismail@gmail.com',
                'password' => bcrypt('ismail123'),
                'user_type' => 'admin',
            ]
        );
    }
}
