<?php

use Illuminate\Support\Facades\Route;
<<<<<<< HEAD
use App\Http\Controllers\CartController;
=======
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\FournisseurController;
>>>>>>> 2ae6c37 (Super admin can create new admin users)
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\MyAccountController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\Admin\DiscountController;
<<<<<<< HEAD
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Api\OrderStatusController;
use App\Http\Controllers\Admin\StatisticsController;
use App\Http\Controllers\Admin\AdminProductController;
=======
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\AdminUserController;
>>>>>>> 2ae6c37 (Super admin can create new admin users)


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

<<<<<<< HEAD
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


=======
Route::middleware('admin')->group(function () {
    Route::get('/admin', 'App\Http\Controllers\Admin\AdminHomeController@index')->name("admin.home.index");
    Route::get('/admin/products', 'App\Http\Controllers\Admin\AdminProductController@index')->name("admin.products.index");
    Route::post('/admin/products/store', 'App\Http\Controllers\Admin\AdminProductController@store')->name("admin.product.store");
    Route::delete('/admin/products/{id}/delete', 'App\Http\Controllers\Admin\AdminProductController@delete')->name("admin.product.delete");
    Route::get('/admin/products/{id}/edit', 'App\Http\Controllers\Admin\AdminProductController@edit')->name("admin.product.edit");
    Route::put('/admin/products/{id}/update', 'App\Http\Controllers\Admin\AdminProductController@update')->name("admin.product.update");
});


Route::middleware(['auth', 'super_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', AdminUserController::class);
});

Route::middleware(['auth', 'super_admin'])->group(function () {
    Route::get('admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('admin/users/create', [AdminUserController::class, 'create'])->name('admin.users.create');
    Route::post('admin/users', [AdminUserController::class, 'store'])->name('admin.users.store');
    Route::get('admin/users{id}', [AdminUserController::class, 'show'])->name('admin.users.show');
    Route::get('admin/users/{id}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
    Route::put('admin/users/{id}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('admin/users/{id}', [AdminUserController::class, 'destory'])->name('admin.users.destroy');
});


>>>>>>> 2ae6c37 (Super admin can create new admin users)
Auth::routes();

Route::resource('categorie', CategorieController::class);
Route::resource('fournisseurs', FournisseurController::class);

Route::get('/discounts/global', [AdminHomeController::class, 'manageGlobalDiscount'])->name('discounts.manageGlobal');
Route::post('/discounts/global', [AdminHomeController::class, 'storeGlobalDiscount'])->name('discounts.storeGlobal');

Route::get('/products/{product}/discount', [AdminProductController::class, 'manageDiscount'])->name('products.manageDiscount');
Route::post('/products/{product}/discount', [AdminProductController::class, 'storeDiscount'])->name('products.storeDiscount');

Route::get('/categories/{categorie}/discount', [AdminProductController::class, 'manageCategorieDiscount'])->name('categories.manageDiscount');
Route::post('/categories/{categorie}/discount', [AdminProductController::class, 'storeCategorieDiscount'])->name('categories.storeDiscount');
<<<<<<< HEAD


Route::get('/commande/{id}/suivi', [OrderStatusController::class, 'showStatus'])->name('order.status');
=======
>>>>>>> 2ae6c37 (Super admin can create new admin users)
