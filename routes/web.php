<?php
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductReturnController as AdminProductReturnController;
use App\Http\Controllers\Admin\PromoController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\SkuController as AdminSkuController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Customer\AddressController;
use App\Http\Controllers\Customer\BrandController as CustomerBrandController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;
use App\Http\Controllers\Customer\PaymentOptionController;
use App\Http\Controllers\Customer\ProductReturnController as CustomerProductReturnController;
use App\Http\Controllers\Customer\ReviewController as CustomerReviewController;
use App\Http\Controllers\Customer\WishlistController;
use App\Http\Controllers\Product\SkuController as ProductSkuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubCategoryController;
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

Route::middleware(['auth', 'verified'])->group(function (){
    Route::get('/admin/dashboard', function () {  return Inertia::render('Admin/Dashboard'); })->name('dashboard');
    Route::get('/overview', function () {  return Inertia::render('Dashboard/Overview'); })->name('overview');
});

// All Admin Routes with middleware
Route::middleware(['auth', 'admin'])->group(function () {
    // Admin Order Routes
    Route::post('/admin/orders/{order}', [AdminOrderController::class, 'update'])->name('admin.orders.update');

    // Admin Product Routes
    Route::get('/admin/products', [AdminSkuController::class, 'index'])->name('admin.products.index');
    Route::post('/admin/products', [AdminSkuController::class, 'store'])->name('admin.products.store');
    Route::post('/admin/products/search', [AdminSkuController::class, 'search'])->name('admin.products.search');
    Route::get('/admin/products/create', [AdminSkuController::class, 'create'])->name('admin.products.create');
    Route::get('/admin/products/{sku}/edit', [AdminSkuController::class, 'edit'])->name('admin.products.edit');
    Route::patch('/admin/products/{product}', [AdminSkuController::class, 'update'])->name('admin.products.update');
    Route::delete('/admin/products/{product}', [AdminSkuController::class, 'destroy'])->name('admin.products.destroy');

    // Admin ProductReturn Routes
    Route::post('/admin/returns', [AdminProductReturnController::class, 'update'])->name('admin.returns.update');
    Route::post('/admin/returns/status', [AdminProductReturnController::class, 'updateStatus'])->name('admin.returns.updateStatus');

    // Admin Review Routes
    Route::get('/admin/reviews/{id}', [AdminReviewController::class, 'getAllReviews'])->name('reviews.index');
    Route::get('/admin/reviews/toggle/{id}', [AdminReviewController::class, 'toggleInactive'])->name('reviews.create');

    // Admin Promo Routes
    Route::get('/promos/create', [PromoController::class, 'create'])->name('promos.create');
    Route::get('/promos/{promo}', [PromoController::class, 'show'])->name('promos.show');
    Route::get('/promos/{promo}/edit', [PromoController::class, 'edit'])->name('promos.edit');
    Route::post('/promos', [PromoController::class, 'store'])->name('promos.store');
    Route::patch('/promos/{promo}', [PromoController::class, 'update'])->name('promos.update');
    Route::delete('/promos/{promo}', [PromoController::class, 'destroy'])->name('promos.destroy');
});

// All routes where user has to be logged in
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Customer Review Routes
    Route::post('/reviews', [CustomerReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [CustomerReviewController::class, 'destroy'])->name('reviews.destroy');

    // Upvote Review Routes
    Route::get('/upvote/{id}', [CustomerReviewController::class, 'markAsUseful'])->name('review.upvote');
    Route::get('/downvote/{id}', [CustomerReviewController::class, 'markAsNotUseful'])->name('review.downvote');

    // Cart Routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{product}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{product}', [CartController::class, 'destroy'])->name('cart.destroy');

    // Wishlist Routes
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{product}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');

    // Address Routes
    Route::get('/addresses', [AddressController::class, 'getAddressesPerUser'])->name('addresses.getAddressesPerUser');
    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::patch('/addresses/{address}', [AddressController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{address}', [AddressController::class, 'destroy'])->name('addresses.destroy');

    // PaymentOption Routes
    Route::get('/payment', [PaymentOptionController::class, 'getPaymentOptionsPerUser'])->name('payment.index');
    Route::post('/payment', [PaymentOptionController::class, 'store'])->name('payment.store');
    Route::delete('/payment/{id}', [PaymentOptionController::class, 'destroy'])->name('payment.destroy');

    // Order Routes
    Route::get('/orders', [CustomerOrderController::class, 'getOrdersByUser'])->name('orders.getOrdersByUser');
    Route::get('/orders/{order}', [CustomerOrderController::class, 'show'])->name('orders.show');
    Route::get('orders/cancel/{order}', [CustomerOrderController::class, 'cancelOrder'])->name('orders.cancel');
    Route::post('/orders', [CustomerOrderController::class, 'store'])->name('orders.store');

    // Customer ProductReturn Routes
    Route::get('/returns', [CustomerProductReturnController::class, 'getReturnByUser'])->name('returns.getReturnByUser');
    Route::post('/returns', [CustomerProductReturnController::class, 'store'])->name('returns.store');
    Route::get('/returns/{return}', [CustomerProductReturnController::class, 'show'])->name('returns.show');

    // User Routes
    Route::patch('/users/{user}/bank', [UserController::class, 'updateBankAccount'])->name('users.updateBankAccount');
    Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

// Wishlist Routes
Route::get('/wishlist/count', [WishlistController::class, 'getAmountOfItemsInWishlist'])->name('wishlist.getCount');

// Product Routes
Route::get('/products', [ProductSkuController::class, 'index'])->name('products.index');
Route::get('/product/{id}',  [ProductSkuController::class, 'show'])->name('product.show');
Route::get('/products/shoes', [ProductSkuController::class, 'showShoes'])->name('shoes');
Route::get('/products/clothing', [ProductSkuController::class, 'showClothing'])->name('clothing');
Route::get('/products/accessories', [ProductSkuController::class, 'showAccessories'])->name('accessories');
Route::get('/products/promos', [ProductSkuController::class, 'showPromos'])->name('promos');
Route::get('/products/{subCategory}', [ProductSkuController::class, 'showBySubCategory'])->name('products.showBySubCategory');

// Filter Routes
Route::post('/filter', [ProductSkuController::class, 'filter'])->name('products.filter');

// User Routes
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
Route::post('/users', [UserController::class, 'store'])->name('users.store');

// (Sub)Category Routes
Route::get('/categories', [CategoryController::class, 'getAllCategories'])->name('admin.categories.getAll');
Route::get('/subcategories', [SubCategoryController::class, 'getAll'])->name('admin.subcategories.getAll');
Route::get('/subcategories/{id}', [SubCategoryController::class, 'getSubCategoriesById'])->name('admin.subcategories.getById');

// Brand Routes
Route::get('/brands', [CustomerBrandController::class, 'index'])->name('brands.index');
Route::get('/brands/{brand}', [CustomerBrandController::class, 'show'])->name('brands.show');

require __DIR__.'/auth.php';
