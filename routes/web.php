<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MyAccountController;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\StatisticsController;

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
    Route::get('/cart/purchase', [CartController::class, 'purchase'])->name("cart.purchase");
    Route::get('/my-account/orders', [MyAccountController::class, 'orders'])->name("myaccount.orders");
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminHomeController::class, 'index'])->name("home.index");

    // Products
    Route::get('/products', [AdminProductController::class, 'index'])->name('product.index');
    Route::post('/products/store', [AdminProductController::class, 'store'])->name("product.store");
    Route::delete('/products/{id}/delete', [AdminProductController::class, 'delete'])->name("product.delete");
    Route::get('/products/{id}/edit', [AdminProductController::class, 'edit'])->name("product.edit");
    Route::put('/products/{id}/update', [AdminProductController::class, 'update'])->name("product.update");

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
