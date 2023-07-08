<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    // just following laravel best practice route convention
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::controller(App\Http\Controllers\CategoryController::class)->group(function () {
        Route::get('/all/category', 'showAll');
        Route::get('/category', 'index')->name('category');
        Route::get('/category/create', 'create');
        Route::post('/category', 'save');
        Route::get('/category/{uuid}', 'show');
        Route::get('/category/{uuid}/detail', 'detail');
        Route::get('/category/{uuid}/edit', 'edit');
        Route::put('/category/{uuid}', 'update');
        Route::get('/category/{uuid}/delete', 'delete');
        Route::post('/category/{uuid}', 'destroy'); // method DELETE doesn't work, so use post
    });
    
    Route::controller(App\Http\Controllers\BudgetController::class)->group(function () {
        Route::get('/budget', 'index')->name('budget');
        Route::get('/budget/create', 'create');
        Route::post('/budget', 'save');
        Route::get('/budget/{uuid}', 'show');
        Route::get('/budget/history/{uuid}', 'showHistory');
        Route::get('/budget/{uuid}/edit', 'edit');
        Route::put('/budget/{uuid}', 'update');
        Route::get('/budget/{uuid}/delete', 'delete');
        Route::post('/budget/{uuid}/delete', 'destroy');
    });

    Route::controller(App\Http\Controllers\ReportController::class)->group(function () {
        Route::get('/report/last-10-budget-reach-100', 'last10BudgetReach100');
        Route::get('/report/last-10-budget-reach-50', 'last10BudgetReach50');
        Route::get('/report/most-choosen-category', 'mostChoosenCategory');

        Route::get('/report/compare-category', 'compareCategory');
    });


});
