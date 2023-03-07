<?php

use App\Http\Controllers\Customer\AddressController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Product\SkuController as ProductSkuController;
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
Route::get('/dashboard', function () {
    return Inertia::render('Admin/Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// Test Route
Route::get('/test', [ProductSkuController::class, 'index'])->name('test');

// Get specific products
Route::get('/shoes', [ProductVariationController::class, 'showShoes'])->name('shoes');
Route::get('/clothing', [ProductVariationController::class, 'showClothing'])->name('clothing');
Route::get('/accessories', [ProductVariationController::class, 'showAccessories'])->name('accessories');
Route::get('/promos', [ProductVariationController::class, 'showPromos'])->name('promos');

// Product Routes
Route::get('/products/all', [ProductSkuController::class, 'index'])->name('products.getAll');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::patch('/products/{product}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

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




require __DIR__.'/auth.php';
