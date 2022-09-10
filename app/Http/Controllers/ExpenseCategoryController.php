<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use App\Models\Expense;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;


class ExpenseCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Check if admin is making the request to udpate.
        if ($request->user()->user_role_id == 1) {
            return Inertia::render('ExpenseCategory/Index', [
                'userCategory' => ExpenseCategory::all()->map(fn($category) => [
                    'id' => $category->id,
                    'category' => $category->category,
                    'description' => $category->description,
                    'created_at' => date('Y-m-d', strtotime($category->created_at)),
                ]),
            ]);
        }
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
        // Check if admin is making the request to udpate.
        if ($request->user()->user_role_id == 1) {
            $categoryData = Validator::make($request->all(), [
                'category' => 'required',
                'description' => 'required',
            ]);

            // Check validation failure
            if ($categoryData->fails()) {
                return redirect()->back()->withErrors($categoryData)->with('message', "Invalid Input. Please try again.");
            }
            

            $categoryDataValidated = $categoryData->validated();
            ExpenseCategory::Create([
                'category' => $categoryDataValidated['category'],
                'description' => $categoryDataValidated['description'],
            ]);

            return redirect()->back()->with('message', 'Successfully Added New Category');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ExpenseCategory  $expenseCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ExpenseCategory $expenseCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExpenseCategory  $expenseCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ExpenseCategory $expenseCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExpenseCategory  $expenseCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Check if admin is making the request to udpate.
        if ($request->user()->user_role_id == 1) {
            $categoryData = Validator::make($request->all(), [
                'id' => ['required', 'exists:App\Models\ExpenseCategory,id'],
                'category' => 'required',
                'description' => 'required',
            ]);

            // Check validation failure
            if ($categoryData->fails()) {
                return redirect()->back()->withErrors($categoryData)->with('message', "Invalid Input. Please try again.");
            }
            

            $categoryDataValidated = $categoryData->validated();


            if ($request->id == $categoryDataValidated['id']) {
                ExpenseCategory::find($request->input('id'))->update([
                    'category' => $categoryDataValidated['category'],
                    'description' => $categoryDataValidated['description'],
                    ]);
                return redirect()->back()
                        ->with('message', ' Successfully Updated Category.');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExpenseCategory  $expenseCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // Check if admin is making the request to udpate.
        if ($request->user()->user_role_id == 1) {
            $categoryData = Validator::make($request->all(), [
                'id' => ['required', 'exists:App\Models\ExpenseCategory,id'],
                'category' => 'required',
                'description' => 'required',
            ]);

            // Check validation failure
            if ($categoryData->fails()) {
                return redirect()->back()->withErrors($categoryData)->with('message', "Invalid Input. Please try again.");
            }
            
            $categoryDataValidated = $categoryData->validated();


            if ($request->id == $categoryDataValidated['id']) {
                ExpenseCategory::find($request->input('id'))->delete();
                return redirect()->back()
                        ->with('message', ' Successfully Deleted the Category.');
            }
        }
    }
}
