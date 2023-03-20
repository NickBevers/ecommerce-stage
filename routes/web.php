<?php

use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\Admin\BrandController as AdminBrandController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CloudinaryController;
use App\Http\Controllers\Admin\PromoController;
use App\Http\Controllers\Admin\SubCategoryController as AdminSubCategoryController;
use App\Http\Controllers\Customer\AddressController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Product\SkuController as ProductSkuController;
use App\Http\Controllers\Admin\SkuController as AdminSkuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\VerifyCsrfToken as VerifyCsrfTokenMiddleware;
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


// Test Route
Route::get('/test/{id}', [ProductSkuController::class, 'show'])->name('test');

// Get specific products
Route::get('/products/shoes', [ProductSkuController::class, 'showShoes'])->name('shoes');
Route::get('/products/clothing', [ProductSkuController::class, 'showClothing'])->name('clothing');
Route::get('/products/accessories', [ProductSkuController::class, 'showAccessories'])->name('accessories');
Route::get('/products/promos', [ProductSkuController::class, 'showPromos'])->name('promos');

Route::get('/products/{subCategory}', [ProductSkuController::class, 'showBySubCategory'])->name('products.showBySubCategory');

// Product Routes
//Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products', [ProductSkuController::class, 'index'])->name('products.index');
Route::get('/product/{id}',  [ProductSkuController::class, 'show'])->name('product.show');
Route::get('/product/{product}/edit', [ProductSkuController::class, 'edit'])->name('product.edit');
Route::patch('/product/{product}', [ProductSkuController::class, 'update'])->name('product.update');
Route::delete('/product/{product}', [ProductSkuController::class, 'destroy'])->name('product.destroy');

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

    Route::post('/admin/products', [AdminSkuController::class, 'store'])->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)->name('admin.products.store');
Route::middleware('auth')->group(function () {
    Route::get('/admin/test', [\App\Http\Controllers\Admin\SubCategoryController::class, 'getAll'])->name('admin.test');
    Route::get('/admin/products', [AdminSkuController::class, 'index'])->name('admin.products.index');
    Route::post('/admin/products/search', [AdminSkuController::class, 'search'])->name('admin.products.search');
    Route::get('/admin/products/create', [AdminSkuController::class, 'create'])->name('admin.products.create');
//    Route::get('/admin/products/{product}', [AdminSkuController::class, 'show'])->name('admin.products.show');
//    Route::get('/admin/products/{product}/edit', [AdminSkuController::class, 'edit'])->name('admin.products.edit');
    Route::patch('/admin/products/{product}', [AdminSkuController::class, 'update'])->name('admin.products.update');
//    Route::delete('/admin/products/{product}', [AdminSkuController::class, 'destroy'])->name('admin.products.destroy');

    Route::get('/admin/categories', [AdminCategoryController::class, 'getAllCategories'])->name('admin.categories.getAll');
    Route::get('/admin/subcategories/{id}', [AdminSubcategoryController::class, 'getSubCategoriesById'])->name('admin.subcategories.getById');
});

Route::get('/admin/subcategories', [AdminSubcategoryController::class, 'getAll'])->name('admin.subcategories.getAll');

//TODO: make promo routes
Route::get('/promos', [PromoController::class, 'index'])->name('promos.index');
Route::post('/promos', [PromoController::class, 'store'])->name('promos.store');
Route::get('/promos/create', [PromoController::class, 'create'])->name('promos.create');
Route::get('/promos/{promo}', [PromoController::class, 'show'])->name('promos.show');
Route::get('/promos/{promo}/edit', [PromoController::class, 'edit'])->name('promos.edit');
Route::patch('/promos/{promo}', [PromoController::class, 'update'])->name('promos.update');
Route::delete('/promos/{promo}', [PromoController::class, 'destroy'])->name('promos.destroy');


require __DIR__.'/auth.php';
