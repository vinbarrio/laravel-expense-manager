<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\UserRole::factory()->create([
            'id' => 1,
            'description' => 'super user',
            'role' => 'administrator',
        ]);

        \App\Models\UserRole::factory()->create([
            'id' => 2,
            'description' => 'can add expenses',
            'role' => 'user',
        ]);
    }
}
