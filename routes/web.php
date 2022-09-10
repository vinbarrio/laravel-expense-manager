<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ExpenseCategoryController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard', [
        'name' => 'vin',
        'time' => now()->toTimeString(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');


Route::controller(UserController::class)->group(function() {
    Route::get('users', 'index')->middleware(['auth', 'verified'])->name('user');
    Route::post('users', 'store')->middleware(['auth', 'verified']);
    Route::patch('users/edit/{id}', 'update')->middleware(['auth', 'verified']);
    Route::delete('users/delete/{id}', 'destroy')->middleware(['auth', 'verified']);
});

Route::controller(UserRoleController::class)->group(function() {
    Route::get('roles', 'index')->middleware(['auth', 'verified'])->name('role');
    Route::post('roles', 'store')->middleware(['auth', 'verified']);
    Route::patch('roles/edit/{id}', 'update')->middleware(['auth', 'verified']);
    Route::delete('roles/delete/{id}', 'destroy')->middleware(['auth', 'verified']);
});


Route::controller(ExpenseCategoryController::class)->group(function() {
    Route::get('expensecategories', 'index')->middleware(['auth', 'verified'])->name('expenseCategory');
    Route::post('expensecategories', 'store')->middleware(['auth', 'verified']);
    Route::patch('expensecategories/edit/{id}', 'update')->middleware(['auth', 'verified']);
    Route::delete('expensecategories/delete/{id}', 'destroy')->middleware(['auth', 'verified']);
});

Route::controller(ExpenseController::class)->group(function() {
    Route::get('expenses', 'index')->middleware(['auth', 'verified'])->name('expense');
    Route::post('expenses', 'store')->middleware(['auth', 'verified']);
    Route::patch('expenses/edit/{id}', 'update')->middleware(['auth', 'verified']);
    Route::delete('expenses/delete/{id}', 'destroy')->middleware(['auth', 'verified']);
});

// Route::get('/users', function () {
//     return Inertia::render('User', [
//         'users' => User::all()->map(fn($user) => [
//             'name' => $user->name
//         ]),
//     ]);
// })->middleware(['auth', 'verified'])->name('user');

require __DIR__.'/auth.php';
