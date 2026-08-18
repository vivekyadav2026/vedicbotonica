<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ReturnController;
use Illuminate\Support\Facades\Route;

// Admin controllers
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\BannerController as AdminBannerController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\ComboController as AdminComboController;
use App\Http\Controllers\Admin\ReturnController as AdminReturnController;

Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/about', [FrontendController::class, 'about'])->name('about');
Route::get('/shop', [FrontendController::class, 'shop'])->name('shop');
Route::get('/product/{slug}', [FrontendController::class, 'product'])->name('product.show');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');

// Policy Pages (Razorpay compliant)
Route::get('/terms-and-conditions', [FrontendController::class, 'terms'])->name('terms');
Route::get('/privacy-policy', [FrontendController::class, 'privacy'])->name('privacy');
Route::get('/refund-policy', [FrontendController::class, 'refund'])->name('refund');
Route::get('/cancellation-policy', [FrontendController::class, 'cancellation'])->name('cancellation');
Route::get('/shipping-policy', [FrontendController::class, 'shipping'])->name('shipping');

// API/Ajax Routes for Cart, Wishlist, and Quick View
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/add-bundle', [CartController::class, 'addBundle'])->name('cart.add-bundle');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/super-save-offer', function() {
    $category = \App\Models\Category::where('slug', 'dhoop-packs')->first();
    if ($category) {
        return redirect('/shop?categories[]=' . $category->id);
    }
    return redirect('/shop');
})->name('bundle.builder');

// Checkout Routes (require login)
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::post('/checkout/razorpay-callback', [CheckoutController::class, 'handleRazorpayCallback'])->name('checkout.razorpay.callback');
    Route::get('/checkout/cancel-payment', [CheckoutController::class, 'cancelRazorpayPayment'])->name('checkout.razorpay.cancel');
    Route::get('/order-success/{order_number}', [CheckoutController::class, 'success'])->name('checkout.success');
});

Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
Route::get('/wishlist/count', [WishlistController::class, 'count'])->name('wishlist.count');
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');

Route::get('/api/product/{slug}', [FrontendController::class, 'apiProductDetails'])->name('api.product.details');

Route::get('/dashboard', function () {
    $orders = App\Models\Order::where('user_id', auth()->id())->with(['items', 'returnRequests'])->latest()->get();
    return view('dashboard', compact('orders'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Returns
    Route::get('/orders/{order}/return', [ReturnController::class, 'create'])->name('orders.return.create');
    Route::post('/orders/{order}/return', [ReturnController::class, 'store'])->name('orders.return.store');
});

// Custom Admin Panel routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('products', AdminProductController::class);
    Route::resource('combos', AdminComboController::class);
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('banners', AdminBannerController::class);
    Route::resource('testimonials', AdminTestimonialController::class);
    Route::resource('reviews', AdminReviewController::class);
    // Route::resource('coupons', AdminCouponController::class);
    
    // Orders
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::post('orders/{order}/shiprocket', [AdminOrderController::class, 'pushToShiprocket'])->name('orders.shiprocket');

    // Returns
    Route::get('returns', [AdminReturnController::class, 'index'])->name('returns.index');
    Route::get('returns/{returnRequest}', [AdminReturnController::class, 'show'])->name('returns.show');
    Route::post('returns/{returnRequest}/status', [AdminReturnController::class, 'updateStatus'])->name('returns.updateStatus');

    // Settings
    Route::get('settings', [AdminController::class, 'settings'])->name('settings.edit');
    Route::post('settings', [AdminController::class, 'updateSettings'])->name('settings.update');
});

require __DIR__.'/auth.php';

// Razorpay Webhook — excluded from CSRF and auth middleware
Route::withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])->post(
    '/webhook/razorpay',
    [CheckoutController::class, 'razorpayWebhook']
)->name('webhook.razorpay');
