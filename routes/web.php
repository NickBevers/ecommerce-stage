<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShippingAddressesController;
use App\Http\Controllers\UsersController;
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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/users', [UsersController::class, 'index'])->name('users.index');
Route::post('/users', [UsersController::class, 'store'])->name('users.store');
Route::get('/users/{user}', [UsersController::class, 'show'])->name('users.show');
Route::get('/users/{user}/edit', [UsersController::class, 'edit'])->name('users.edit');
Route::patch('/users/{user}', [UsersController::class, 'update'])->name('users.update');
Route::patch('/users/{user}/bank', [UsersController::class, 'updateBankAccount'])->name('users.updateBankAccount');
Route::delete('/users/{user}', [UsersController::class, 'destroy'])->name('users.destroy');

Route::get('/shipping-addresses', [ShippingAddressesController::class, 'index'])->name('shipping.index');
Route::post('/shipping-addresses', [ShippingAddressesController::class, 'store'])->name('shipping.store');
Route::get('/shipping-addresses/{shippingAddress}', [ShippingAddressesController::class, 'show'])->name('shipping.show');
Route::get('/shipping-addresses/{shippingAddress}/edit', [ShippingAddressesController::class, 'edit'])->name('shipping.edit');
Route::patch('/shipping-addresses/{shippingAddress}', [ShippingAddressesController::class, 'update'])->name('shipping.update');
Route::delete('/shipping-addresses/{shippingAddress}', [ShippingAddressesController::class, 'destroy'])->name('shipping.destroy');




require __DIR__.'/auth.php';
