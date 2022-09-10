<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;


class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Expense/Index', [
            'expenses' => Expense::all()->map(fn($expense) => [
                'id' => $expense->id,
                'category_id' => $expense->expense_category_id,
                'category_name' => $expense->expenseCategory->category,
                'amount' => number_format($expense->amount, 2),
                'entry_date' => $expense->entry_date,
                'created_at' => date('Y-m-d', strtotime($expense->created_at)),

            ]),
            'expenseCategories' => ExpenseCategory::all()->map(fn($category) => [
                'id' => $category->id,
                'category' => $category->category,
            ]),
        ]);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newExpense = Validator::make($request->all(), [
            'category' => ['required', 'exists:App\Models\ExpenseCategory,id'],
            'amount' => ['required', 'numeric','between:-9999999999.99,9999999999.99'],
            'entry_date' => 'date'
        ]);
        // Check validation failure
        if ($newExpense->fails()) {
            return redirect()->back()->withErrors($newExpense)->with('message', "Invalid Input. Please try again.");
        }
        

        $newExpenseValidated = $newExpense->validated();
        Expense::create([
            'amount' => $newExpenseValidated['amount'],
            'entry_date' => $newExpenseValidated['entry_date'],
            'expense_category_id' => $newExpenseValidated['category'],
        ]);
        return redirect()->back()->with('message', 'Successfully Added New Expense');      

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $newExpense = Validator::make($request->all(), [
            'id' => ['required', 'exists:App\Models\Expense,id'],
            'category' => ['required', 'exists:App\Models\ExpenseCategory,id'],
            'amount' => ['required', 'numeric','between:-9999999999.99,9999999999.99'],
            'entry_date' => ['date']
        ]);
        
        // Check validation failure
        if ($newExpense->fails()) {
            return redirect()->back()->withErrors($newExpense)->with('message', "Invalid Input. Please try again.");
        }

        $newExpenseValidated = $newExpense->validated();

        if ($request->id == $newExpenseValidated['id']) {
            Expense::find($request->input('id'))->update([
                'expense_category_id' => $newExpenseValidated['category'],
                'amount' => $newExpenseValidated['amount'],
                'entry_date' => $newExpenseValidated['entry_date'],
                ]);
            return redirect()->back()
                    ->with('message', ' Successfully Updated User.');
        }

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $expeseID = Validator::make($request->all(), [
            'id' => ['required', 'exists:App\Models\Expense,id'],
        ]);
        
        // Check validation failure
        if ($expeseID->fails()) {
            return redirect()->back()->withErrors($expeseID)->with('message', "Invalid Input. Please try again.");
        }

        $expenseIDValidated = $expeseID->validated();

        if ($request->id == $expenseIDValidated['id']) {
            Expense::find($request->input('id'))->delete();
            return redirect()->back()
                    ->with('message', ' Successfully Deleted Expense');
        }
    }
}
