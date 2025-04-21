<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\MyAccountController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Api\OrderStatusController;
use App\Http\Controllers\Admin\StatisticsController;
use App\Http\Controllers\Admin\AdminProductController;


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

Route::get('/', 'App\Http\Controllers\HomeController@index')->name("home.index");
Route::get('/about', 'App\Http\Controllers\HomeController@about')->name("home.about");
Route::get('/products', 'App\Http\Controllers\ProductController@index')->name("product.index");
Route::get('/products/{id}', 'App\Http\Controllers\ProductController@show')->name("product.show");

Route::get('/cart', 'App\Http\Controllers\CartController@index')->name("cart.index");
Route::get('/cart/delete', 'App\Http\Controllers\CartController@delete')->name("cart.delete");
Route::post('/cart/add/{id}', 'App\Http\Controllers\CartController@add')->name("cart.add");

Route::middleware('auth')->group(function () {
    Route::get('/cart/purchase', 'App\Http\Controllers\CartController@purchase')->name("cart.purchase");
    Route::get('/my-account/orders', 'App\Http\Controllers\MyAccountController@orders')->name("myaccount.orders");
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
    Route::get('/products/export', [AdminProductController::class, 'exportCSV'])->name('product.export');
    Route::post('/products/import', [AdminProductController::class, 'importCSV'])->name('product.import');
    Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index');
    Route::get('/statistics/pdf', [StatisticsController::class, 'downloadPDF'])->name('statistics.pdf');
    Route::get('/statistics/export-pdf', [StatisticsController::class, 'exportPdf'])->name('statistics.exportPdf');
    Route::get('/home', [AdminHomeController::class, 'index'])->name('home.index');
    Route::post('/products', [AdminProductController::class, 'store'])->name('product.store');
    Route::get('/products/{id}/edit', [AdminProductController::class, 'edit'])->name('product.edit');
    Route::put('/products/{id}', [AdminProductController::class, 'update'])->name('product.update'); 
    Route::delete('/products/{id}', [AdminProductController::class, 'destroy'])->name('product.delete'); 

});


Auth::routes();

Route::resource('categorie', CategorieController::class);
Route::resource('fournisseurs', FournisseurController::class);

Route::get('/discounts/global', [AdminHomeController::class, 'manageGlobalDiscount'])->name('discounts.manageGlobal');
Route::post('/discounts/global', [AdminHomeController::class, 'storeGlobalDiscount'])->name('discounts.storeGlobal');

Route::get('/products/{product}/discount', [AdminProductController::class, 'manageDiscount'])->name('products.manageDiscount');
Route::post('/products/{product}/discount', [AdminProductController::class, 'storeDiscount'])->name('products.storeDiscount');

Route::get('/categories/{categorie}/discount', [AdminProductController::class, 'manageCategorieDiscount'])->name('categories.manageDiscount');
Route::post('/categories/{categorie}/discount', [AdminProductController::class, 'storeCategorieDiscount'])->name('categories.storeDiscount');


Route::get('/commande/{id}/suivi', [OrderStatusController::class, 'showStatus'])->name('order.status');
