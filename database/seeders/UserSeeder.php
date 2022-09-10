<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()->create([
             'name' => 'Admin Account',
             'email' => 'admin@mail.com',
             'user_role_id' => 1,
             'password' => 'secret',
         ]);

         \App\Models\User::factory()->create([
            'name' => 'User Account',
            'email' => 'user@mail.com',
            'user_role_id' => 2,
            'password' => 'secret',
        ]);
    }
}
