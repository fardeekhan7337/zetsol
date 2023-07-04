<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// for admin
Route::group(['prefix' => 'admin', 'middleware' => ['auth'], 'as' => 'admin:'], function () {

    // PRODUCTS
    Route::get('/products', [AdminController::class, 'products'])->name('products');
    Route::get('/add_product', [AdminController::class, 'add_product'])->name('add_product');
    Route::post('/save_product', [AdminController::class, 'save_product'])->name('save_product');
    Route::get('/{id}/edit_product', [AdminController::class, 'edit_product'])->name('edit_product');
    Route::put('/update_product/{id}', [AdminController::class, 'update_product'])->name('update_product');
    Route::delete('/delete_product/{id}', [AdminController::class, 'delete_product'])->name('delete_product');
    Route::get('/view_product/{id}', [AdminController::class, 'view_product'])->name('view_product');

    // STOCK
    Route::get('/products', [AdminController::class, 'products'])->name('products');
    Route::get('/add_product', [AdminController::class, 'add_product'])->name('add_product');
    Route::post('/save_product', [AdminController::class, 'save_product'])->name('save_product');
    Route::get('/{id}/edit_product', [AdminController::class, 'edit_product'])->name('edit_product');
    Route::put('/update_product/{id}', [AdminController::class, 'update_product'])->name('update_product');
    Route::delete('/delete_product/{id}', [AdminController::class, 'delete_product'])->name('delete_product');
    Route::get('/view_product/{id}', [AdminController::class, 'view_product'])->name('view_product');
    
});