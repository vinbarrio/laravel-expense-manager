<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpenseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\ExpenseCategory::factory()->create([
            'id' => 1,
            'category' => 'Travel',
            'description' => 'daily commute',
            
        ]);

        \App\Models\ExpenseCategory::factory()->create([
            'id' => 2,
            'category' => 'Entertainment',
            'description' => 'movies etc',
        ]);
    }
}
