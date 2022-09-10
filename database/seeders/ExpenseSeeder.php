<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Expense::factory()->create([
            'expense_category_id' => '1',
            'amount' => 100.00,
            'entry_date' => '2022-09-09'
        ]);

        \App\Models\Expense::factory()->create([
            'expense_category_id' => '2',
            'amount' => 250.50,
            'entry_date' => '2022-09-10'
        ]);
    }
}
