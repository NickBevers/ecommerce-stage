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
use App\Http\Controllers\Customer\PaymentTypeController;
use App\Http\Controllers\Customer\ProductReturnController as CustomerProductReturnController;
use App\Http\Controllers\Customer\ReviewController as CustomerReviewController;
use App\Http\Controllers\Customer\WishlistController;
use App\Http\Controllers\Product\SkuController as ProductSkuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Models\PaymentType;
use App\Services\SubCategoryService;
use App\Services\VatService;
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

    Route::get('/admin/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Admin Order Routes
    Route::post('/admin/orders/{order}', [AdminOrderController::class, 'update'])->name('admin.orders.update');
    Route::patch('/admin/orders/product/{order}', [AdminOrderController::class, 'updateOrderLine'])->name('admin.orders.updateOrderLine');
    Route::delete('/admin/orders/product/{order}', [AdminOrderController::class, 'deleteOrderLine'])->name('admin.orders.deleteOrderLine');

    // Admin Product Routes
    Route::get('/admin/products', [AdminSkuController::class, 'index'])->name('admin.products.index');
    Route::post('/admin/products', [AdminSkuController::class, 'store'])->name('admin.products.store');
    Route::post('/admin/products/search', [AdminSkuController::class, 'search'])->name('admin.products.search');
    Route::get('/admin/products/create', [AdminSkuController::class, 'create'])->name('admin.products.create');
    Route::get('/admin/products/{sku}/edit', [AdminSkuController::class, 'edit'])->name('admin.products.edit');
    Route::patch('/admin/products/{sku}', [AdminSkuController::class, 'update'])->name('admin.products.update');
    Route::delete('/admin/products/{sku}', [AdminSkuController::class, 'destroy'])->name('admin.products.destroy');

    // Admin ProductReturn Routes
    Route::post('/admin/returns', [AdminProductReturnController::class, 'update'])->name('admin.returns.update');
    Route::post('/admin/returns/status', [AdminProductReturnController::class, 'updateStatus'])->name('admin.returns.updateStatus');

    // Admin Review Routes
    Route::get('/admin/reviews/{sku}', [AdminReviewController::class, 'getAllReviews'])->name('reviews.index');
    Route::get('/admin/reviews/toggle/{sku}', [AdminReviewController::class, 'toggleInactive'])->name('reviews.create');

    // Admin User Routes
    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');

    // Admin Order Routes
    Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/admin/orders/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');

    // Admin Promo Routes
    Route::get('/promos/create', [PromoController::class, 'create'])->name('promos.create');
    Route::get('/promos/{promo}/edit', [PromoController::class, 'edit'])->name('promos.edit');
    Route::post('/promos', [PromoController::class, 'store'])->name('promos.store');
    Route::patch('/promos/{promo}', [PromoController::class, 'update'])->name('promos.update');
    Route::delete('/promos/{promo}', [PromoController::class, 'destroy'])->name('promos.destroy');

    // Admin Country Routes
    Route::get('/admin/getVats/{code}', [VatService::class, 'getVatsByCountryCode'])->name('admin.countries.getVats');
});

// All routes where user has to be logged in
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'userEdit'])->name('profile.userEdit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/profile/password', [ProfileController::class, 'editPassword'])->name('profile.editPassword');
    Route::get('/profile/advanced', [ProfileController::class, 'editAdvanced'])->name('profile.editAdvanced');

    // Customer Review Routes
    Route::post('/reviews', [CustomerReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [CustomerReviewController::class, 'destroy'])->name('reviews.destroy');

    // Upvote Review Routes
    Route::get('/upvote/{review}', [CustomerReviewController::class, 'markAsUseful'])->name('review.upvote');
    Route::get('/downvote/{review}', [CustomerReviewController::class, 'markAsNotUseful'])->name('review.downvote');

    // Cart Routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::get('/cart/products', [CartController::class, 'getProductsPerUser'])->name('cart.getProductsPerUser');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{sku}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{sku}', [CartController::class, 'destroy'])->name('cart.destroy');

    // Route::get('/checkout', function () {  return Inertia::render('Customer/Checkout/Index'); })->name('checkout.index');

    // Wishlist Routes
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{sku}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');

    // Address Routes
    Route::get('/addresses', [AddressController::class, 'getAddressesPerUser'])->name('addresses.getAddressesPerUser');
    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::patch('/addresses/{address}', [AddressController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{address}', [AddressController::class, 'destroy'])->name('addresses.destroy');

    // UserPaymentMethod Routes
    Route::get('/payment', [PaymentTypeController::class, 'index'])->name('payment.index');
//    Route::post('/payment', [PaymentTypeController::class, 'store'])->name('payment.store');
//    Route::delete('/payment/{paymentOption}', [PaymentTypeController::class, 'destroy'])->name('payment.destroy');

    // Order Routes
    Route::get('/orders', [CustomerOrderController::class, 'getOrdersByUser'])->name('orders.getOrdersByUser');
    Route::get('/orders/{order}', [CustomerOrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/cancel/{order}', [CustomerOrderController::class, 'cancelOrder'])->name('orders.cancel');
    Route::post('/orders', [CustomerOrderController::class, 'store'])->name('orders.store');
    Route::post('/orders/update/{order}', [AdminOrderController::class, 'update'])->name('orders.update');

    // Customer ProductReturn Routes
    Route::get('/returns', [CustomerProductReturnController::class, 'getReturnByUser'])->name('returns.getReturnByUser');
    Route::post('/returns', [CustomerProductReturnController::class, 'store'])->name('returns.store');
    Route::get('/returns/{return}', [CustomerProductReturnController::class, 'show'])->name('returns.show');

    // User Routes
    Route::patch('/users/{user}/bank', [UserController::class, 'updateBankAccount'])->name('users.updateBankAccount');
    Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Checkout Routes
    Route::get('/checkout', [CartController::class, 'getCheckoutData'])->name('checkout.getCheckoutData');

    // Country Routes
    Route::get('/countries', [VatService::class, 'getCountries'])->name('countries.index');
});

// Wishlist Routes
Route::get('/wishlist/count', [WishlistController::class, 'getAmountOfItemsInWishlist'])->name('wishlist.getCount');

// Cart Routes
Route::get('/cart/count', [CartController::class, 'getAmountOfItemsInCart'])->name('cart.getCount');

// Product Routes
Route::get('/product/{sku:sku}',  [ProductSkuController::class, 'show'])->name('product.show');
Route::get('/products/category/{categoryName}', [ProductSkuController::class, 'showByCategory'])->name('products.showByCategory');
Route::get('/products/{subCategory}', [ProductSkuController::class, 'showBySubCategory'])->name('products.showBySubCategory');
Route::get('/products/promos', [ProductSkuController::class, 'showPromos'])->name('promos');

// Filter Routes
Route::post('/filter', [ProductSkuController::class, 'filter'])->name('products.filter');

// User Routes
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
Route::post('/users', [UserController::class, 'store'])->name('users.store');

// (Sub)Category Routes
Route::get('/categories', [CategoryController::class, 'getAllCategories'])->name('admin.categories.getAll');
Route::get('/subcategories', [SubCategoryService::class, 'getAll'])->name('admin.subcategories.getAll');
Route::get('/subcategories/{category}', [SubCategoryService::class, 'getSubCategoriesByCategory'])->name('admin.subcategories.getByCategory');

// Brand Routes
Route::get('/brands', [CustomerBrandController::class, 'index'])->name('brands.index');
Route::get('/brands/{brand:slug}', [CustomerBrandController::class, 'show'])->name('brands.show');

require __DIR__.'/auth.php';
