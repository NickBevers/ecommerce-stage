<?php

use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\Admin\BrandController as AdminBrandController;
use App\Http\Controllers\Customer\AddressController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Product\SkuController as ProductSkuController;
use App\Http\Controllers\Admin\SkuController as AdminSkuController;
use App\Http\Controllers\ProductVariationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

// Root Route
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


// Auth Routes
Route::get('/admin/dashboard', function () {
    return Inertia::render('Admin/Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/overview', function () {
    return Inertia::render('Dashboard/Overview');
})->middleware(['auth', 'verified'])->name('overview');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// Test Route
//Route::get('/test', [ProductSkuController::class, 'filter'])->name('test');

// Get specific products
Route::get('/products/shoes', [ProductSkuController::class, 'showShoes'])->name('shoes');
Route::get('/products/clothing', [ProductSkuController::class, 'showClothing'])->name('clothing');
Route::get('/products/accessories', [ProductSkuController::class, 'showAccessories'])->name('accessories');
Route::get('/products/promos', [ProductSkuController::class, 'showPromos'])->name('promos');

// Product Routes
Route::get('/products', [ProductSkuController::class, 'filter'])->name('products.index');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::patch('/products/{product}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

// Filter Routes
Route::post('/filter', [ProductSkuController::class, 'filter'])->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)->name('products.filter');
Route::get('/filter/size', [AttributeValueController::class, 'getSizes'])->name('products.getSizes');
Route::get('/filter/color', [AttributeValueController::class, 'getColors'])->name('products.getColors');
Route::get('/filter/material', [AttributeValueController::class, 'getMaterials'])->name('products.getMaterials');
Route::get('/filter/brand', [AdminBrandController::class, 'getAllBrands'])->name('products.getBrands');


// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// User Routes
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update');
Route::patch('/users/{user}/bank', [UserController::class, 'updateBankAccount'])->name('users.updateBankAccount');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

// Shipping Address Routes
Route::get('/shipping-addresses', [AddressController::class, 'index'])->name('shipping.index');
Route::post('/shipping-addresses', [AddressController::class, 'store'])->name('shipping.store');
Route::get('/shipping-addresses/{shippingAddress}', [AddressController::class, 'show'])->name('shipping.show');
Route::get('/shipping-addresses/{shippingAddress}/edit', [AddressController::class, 'edit'])->name('shipping.edit');
Route::patch('/shipping-addresses/{shippingAddress}', [AddressController::class, 'update'])->name('shipping.update');
Route::delete('/shipping-addresses/{shippingAddress}', [AddressController::class, 'destroy'])->name('shipping.destroy');

Route::middleware('auth')->group(function () {
    Route::get('/admin/products', [AdminSkuController::class, 'index'])->name('admin.products.index');
    Route::post('/admin/products', [AdminSkuController::class, 'store'])->name('admin.products.store');
    Route::post('/admin/products/search', [AdminSkuController::class, 'search'])->name('admin.products.search');
    Route::get('/admin/products/create', [AdminSkuController::class, 'create'])->name('admin.products.create');
    Route::get('/admin/products/{product}', [AdminSkuController::class, 'show'])->name('admin.products.show');
    Route::get('/admin/products/{product}/edit', [AdminSkuController::class, 'edit'])->name('admin.products.edit');
    Route::patch('/admin/products/{product}', [AdminSkuController::class, 'update'])->name('admin.products.update');
    Route::delete('/admin/products/{product}', [AdminSkuController::class, 'destroy'])->name('admin.products.destroy');
});

//TODO: make promo routes

require __DIR__.'/auth.php';
