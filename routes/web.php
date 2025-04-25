<?php

use App\Http\Controllers\Admin\AdminCategorieController;
use App\Http\Controllers\Admin\AdminFournisseurController as AdminAdminFournisseurController;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\StatisticsController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MyAccountController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SuperAdminUserController\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController as paymentController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Session;

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

Route::get('/', [HomeController::class, 'index'])->name("home.index");
Route::get('/about', [HomeController::class, 'about'])->name("home.about");
Route::get('/products', [ProductController::class, 'index'])->name("product.index");
Route::get('/products/{id}', [ProductController::class, 'show'])->name("product.show");

Route::get('/cart', [CartController::class, 'index'])->name("cart.index");
Route::delete('/cart/delete', [CartController::class, 'delete'])->name("cart.delete");
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name("cart.add");

Route::middleware('auth')->group(function () {
    Route::post('/cart/purchase', [CartController::class, 'purchase'])->name("cart.purchase");

    Route::get('/my-account/orders', [MyAccountController::class, 'orders'])->name("myaccount.orders");
   
    Route::post('/payment', [paymentController::class, 'processPaymentMethod'])->name("payment.add");

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
});

Route::middleware('admin')->group(function () {
    
    Route::get('/admin', [AdminHomeController::class, 'index'])->name("admin.home.index");
    Route::get('/admin/products', [AdminProductController::class, 'index'])->name("admin.product.index");
    Route::post('/admin/products/store', [AdminProductController::class, 'store'])->name("admin.product.store");
    Route::delete('/admin/products/{id}/delete', [AdminProductController::class, 'delete'])->name("admin.product.delete");
    Route::get('/admin/products/{id}/edit', [AdminProductController::class, 'edit'])->name("admin.product.edit");
    Route::put('/admin/products/{id}/update', [AdminProductController::class, 'update'])->name("admin.product.update");
    Route::get('/admin/products/filter', [AdminProductController::class, 'filter'])->name('admin.product.filter');
    Route::get('/admin/products/export', [AdminProductController::class, 'export'])->name('admin.product.export');
    Route::POST('/admin/products/import/', [AdminProductController::class, 'import'])->name('admin.product.import');

    // Category Routes
<<<<<<< HEAD
    Route::get('admin/categories', [AdminCategoryController::class, "index"])->name("admin.categories.index");
    Route::post('admin/categories/store', [AdminCategoryController::class, "store"])->name("admin.category.store");
    Route::delete('admin/categories/{id}', [AdminCategoryController::class, 'delete'])->name("admin.category.delete");
    Route::get('admin/categories/{id}/edit', [AdminCategoryController::class, 'edit'])->name("admin.category.edit");
    Route::put('admin/categories/{id}/update', [AdminCategoryController::class, 'update'])->name("admin.category.update");
=======
    Route::get('admin/categories', [AdminCategorieController::class, "index"])->name("admin.categorie.index");
    Route::post('admin/categories/store', [AdminCategorieController::class, "store"])->name("admin.categorie.store");
    Route::delete('admin/categories/{id}', [AdminCategorieController::class, 'delete'])->name("admin.categorie.delete");
    Route::get('admin/categories/{id}/edit', [AdminCategorieController::class, 'edit'])->name("admin.categorie.edit");
    Route::put('admin/categories/{id}/update', [AdminCategorieController::class, 'update'])->name("admin.categorie.update");
>>>>>>> origin

    Route::resource("admin/fournisseurs", AdminAdminFournisseurController::class);

    Route::get('/admin/statistics', [StatisticsController::class, 'index'])->name('statistics.index');
    Route::get("/admin/statistics/download", [StatisticsController::class, 'exportPdf'])->name('statistics.exportPdf');

    Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.order.index');
    Route::put('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');

    Route::resource('/admin/discounts', \App\Http\Controllers\Admin\AdminDiscountController::class);
});

Route::middleware(['auth', 'super_admin'])->group(function () {
    Route::get('/superAdmin/create', [UserController::class, 'showCreateAdminForm']);
    Route::post('/superAdmin/create', [UserController::class, 'createAdmin'])->name("superAdmin.createAdmin");
    Route::get('/superAdmin', [UserController::class, 'index'])->name("superAdmin.index");
});


Auth::routes();
