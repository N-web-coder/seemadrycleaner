<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\Customer\ProductController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\AccountController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminContactController;

// Public Pages
Route::get('/', [PagesController::class, 'home'])->name('home');
Route::get('/about', [PagesController::class, 'about'])->name('about');
Route::get('/contact', [PagesController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Service Catalog
Route::get('/services', [ProductController::class, 'categories'])->name('categories.index');
Route::get('/services/{category:slug}', [ProductController::class, 'categoryProducts'])->name('categories.show');
Route::get('/product/{product:slug}', [ProductController::class, 'show'])->name('products.show');

// Shopping Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.post')->middleware('guest');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->name('register.post')->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:admin,manager'])->group(function () {
    // Admin & Management
    Route::get('/admin/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('localities', \App\Http\Controllers\LocalityController::class);
        Route::resource('stores', \App\Http\Controllers\StoreController::class);
        Route::resource('categories', \App\Http\Controllers\CategoryController::class);
        Route::resource('products', \App\Http\Controllers\ProductController::class);
        Route::resource('product-options', \App\Http\Controllers\ProductOptionController::class);
        Route::resource('coupons', \App\Http\Controllers\CouponController::class);

        Route::get('orders', [\App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [\App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
        Route::post('orders/{order}/status', [\App\Http\Controllers\OrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::get('orders/{order}/print-tags', [\App\Http\Controllers\OrderController::class, 'printTags'])->name('orders.print-tags');
        Route::get('orders/{order}/receipt', [\App\Http\Controllers\OrderController::class, 'getReceipt'])->name('orders.receipt');

        Route::post('orders/{order}/payment-link', [\App\Http\Controllers\PaymentController::class, 'createPaymentLink'])->name('payments.link');
        Route::get('payments/callback', [\App\Http\Controllers\PaymentController::class, 'handleCallback'])->name('payments.callback');
        Route::post('orders/{order}/mark-paid', [\App\Http\Controllers\PaymentController::class, 'markAsPaid'])->name('payments.mark-paid');

        Route::get('pos', [\App\Http\Controllers\PosController::class, 'index'])->name('pos.index');
        Route::get('pos/find-customer', [\App\Http\Controllers\PosController::class, 'findCustomer'])->name('pos.find-customer');
        Route::post('pos/validate-coupon', [\App\Http\Controllers\PosController::class, 'validateCoupon'])->name('pos.validate-coupon');
        Route::post('pos/store-order', [\App\Http\Controllers\PosController::class, 'storeOrder'])->name('pos.store-order');

        Route::get('inquiries', [AdminContactController::class, 'index'])->name('inquiries.index');
        Route::get('inquiries/{inquiry}', [AdminContactController::class, 'show'])->name('inquiries.show');
        Route::delete('inquiries/{inquiry}', [AdminContactController::class, 'destroy'])->name('inquiries.destroy');

        Route::get('whatsapp', [\App\Http\Controllers\WhatsappController::class, 'index'])->name('whatsapp.index');
        Route::get('whatsapp/session-status', [\App\Http\Controllers\WhatsappController::class, 'checkSessionStatus'])->name('whatsapp.session-status');
        Route::get('whatsapp/logout', [\App\Http\Controllers\WhatsappController::class, 'logout'])->name('whatsapp.logout');
        Route::post('whatsapp/send-message', [\App\Http\Controllers\WhatsappController::class, 'sendMessage'])->name('whatsapp.send-message');

    });
});

Route::middleware(['auth', 'role:customer'])->group(function () {
    // Customer Account (accessible by anyone logged in)
    Route::prefix('account')->name('account.')->group(function () {
        Route::get('/dashboard', [AccountController::class, 'index'])->name('dashboard');
        Route::get('/orders', [AccountController::class, 'orders'])->name('orders');
        Route::get('/orders/{order}', [AccountController::class, 'showOrder'])->name('orders.show');
    });

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
});
