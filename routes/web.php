<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WebsiteController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

// for customer
// Products
Route::get('/', [WebsiteController::class, 'products'])->name('products');
Route::post('/getAllProducts', [WebsiteController::class, 'getAllProducts'])->name('getAllProducts');
Route::post('/add_to_cart_product', [WebsiteController::class, 'add_to_cart_product'])->name('add_to_cart_product');
Route::get('/getAllCartProducts', [WebsiteController::class, 'getAllCartProducts'])->name('getAllCartProducts');
Route::post('clear', [WebsiteController::class, 'clearAllCart'])->name('cart.clear');
Route::post('remove_product', [WebsiteController::class, 'removeProduct'])->name('cart.remove');
Route::post('update_cart', [WebsiteController::class, 'updateCart'])->name('cart.update');
Route::get('/checkout', [WebsiteController::class, 'checkout'])->name('checkout');
Route::post('place_order', [WebsiteController::class, 'placeOrder'])->name('placeOrder');


Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');


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
    Route::get('/stocks', [AdminController::class, 'stocks'])->name('stocks');
    Route::get('/add_stock', [AdminController::class, 'add_stock'])->name('add_stock');
    Route::get('/remove_stock', [AdminController::class, 'remove_stock'])->name('remove_stock');
    Route::post('/save_stock', [AdminController::class, 'save_stock'])->name('save_stock');


    // ORDERS
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::get('/view_order/{id}', [AdminController::class, 'view_order'])->name('view_order');
    Route::post('/update_order_status', [AdminController::class, 'update_order_status'])->name('update_order_status');
    
});