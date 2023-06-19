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
    Route::get('/category', [App\Http\Controllers\CategoryController::class, 'index'])->name('category');
    Route::get('/category/create', [App\Http\Controllers\CategoryController::class, 'create']);
    Route::post('/category', [App\Http\Controllers\CategoryController::class, 'save']);
    Route::get('/category/{uuid}', [App\Http\Controllers\CategoryController::class, 'show']);
    Route::get('/category/{uuid}/edit', [App\Http\Controllers\CategoryController::class, 'edit']);
    Route::put('/category/{uuid}', [App\Http\Controllers\CategoryController::class, 'update']);
    Route::get('/category/{uuid}/delete', [App\Http\Controllers\CategoryController::class, 'delete']);
    Route::post('/category/{uuid}', [App\Http\Controllers\CategoryController::class, 'destroy']); // method doesn't work, so use post
});
