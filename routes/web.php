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
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name("home.index");
Route::get('/about', [HomeController::class, 'about'])->name("home.about");
Route::get('/products', [ProductController::class, 'index'])->name("product.index");
Route::get('/products/{id}', [ProductController::class, 'show'])->name("product.show");

Route::get('/cart', [CartController::class, 'index'])->name("cart.index");
Route::get('/cart/delete', [CartController::class, 'delete'])->name("cart.delete");
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name("cart.add");

Route::middleware('auth')->group(function () {
<<<<<<< HEAD
    Route::get('/cart/purchase', [CartController::class, 'purchase'])->name("cart.purchase");
    Route::get('/my-account/orders', [MyAccountController::class, 'orders'])->name("myaccount.orders");
=======
    Route::get('/cart/purchase', 'App\Http\Controllers\CartController@purchase')->name("cart.purchase");
    Route::get('/my-account/orders', 'App\Http\Controllers\MyAccountController@orders')->name("myaccount.orders");
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
>>>>>>> feature_payement
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminHomeController::class, 'index'])->name("home.index");

<<<<<<< HEAD
    // Products
    Route::get('/products', [AdminProductController::class, 'index'])->name('product.index');
    Route::post('/products/store', [AdminProductController::class, 'store'])->name("product.store");
    Route::delete('/products/{id}/delete', [AdminProductController::class, 'delete'])->name("product.delete");
    Route::get('/products/{id}/edit', [AdminProductController::class, 'edit'])->name("product.edit");
    Route::put('/products/{id}/update', [AdminProductController::class, 'update'])->name("product.update");
=======
Route::prefix('admin')->group(function () {
    Route::get('/products', [AdminProductController::class, 'index'])->name('admin.products.index');
    Route::get('/statistics', [StatisticsController::class, 'index'])->name('admin.statistics.index');
    Route::get('/statistics/pdf', [StatisticsController::class, 'downloadPDF'])->name('admin.statistics.pdf');
    Route::get('/statistics/export-pdf', [StatisticsController::class, 'exportPdf'])->name('admin.statistics.exportPdf');
    Route::get('/product', [AdminProductController::class, 'index'])->name('products.index');
});
>>>>>>> feature_payement

    // Statistics
    Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index');
    Route::get('/statistics/pdf', [StatisticsController::class, 'downloadPDF'])->name('statistics.pdf');
    Route::get('/statistics/export-pdf', [StatisticsController::class, 'exportPdf'])->name('statistics.exportPdf');

    // Discounts
    Route::resource('discounts', DiscountController::class);
});

Auth::routes();

Route::resource('categorie', CategorieController::class);
Route::resource('fournisseurs', FournisseurController::class);

// Gestion des remises (hors admin prefix)
Route::get('/discounts/global', [AdminHomeController::class, 'manageGlobalDiscount'])->name('discounts.manageGlobal');
Route::post('/discounts/global', [AdminHomeController::class, 'storeGlobalDiscount'])->name('discounts.storeGlobal');

Route::get('/products/{product}/discount', [AdminProductController::class, 'manageDiscount'])->name('products.manageDiscount');
Route::post('/products/{product}/discount', [AdminProductController::class, 'storeDiscount'])->name('products.storeDiscount');

Route::get('/categories/{categorie}/discount', [AdminProductController::class, 'manageCategorieDiscount'])->name('categories.manageDiscount');
Route::post('/categories/{categorie}/discount', [AdminProductController::class, 'storeCategorieDiscount'])->name('categories.storeDiscount');
<<<<<<< HEAD
=======

Route::get('/admin/statistics', [StatisticsController::class, 'index'])->name('admin.statistics.index');
Route::get('/admin/statistics/pdf', [StatisticsController::class, 'downloadPDF'])->name('admin.statistics.pdf');
Route::get('admin/statistics/export-pdf', [App\Http\Controllers\Admin\StatisticsController::class, 'exportPdf'])->name('admin.statistics.exportPdf');


Route::get('/commande/{id}/suivi', [OrderStatusController::class, 'showStatus'])->name('order.status');

Route::get('/checkout', [PaymentController::class, 'checkout'])->name('payment.checkout');
Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
>>>>>>> feature_payement
