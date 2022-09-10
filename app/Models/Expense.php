<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    /** The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'expense_category_id',
        'amount',
        'entry_date',
    ]; 

    /**
     * Get the category of this expense.
     */
    public function expenseCategory() {
        return $this->belongsTo(ExpenseCategory::class);
    }
}
