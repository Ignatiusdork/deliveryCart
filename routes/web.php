<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PaymentService;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('dashboard/products', [ProductController::class, 'index'])->name('products.index');
Route::get('dashboard/products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    // Routes accessible to all authenticated users
Route::middleware('auth')->group(function () {
    Route::post('/order/place', [OrderController::class, 'placeOrder'])->name('order.place');
    Route::get('/order/{id}', [OrderController::class, 'showOrder'])->name('orders.show');
    Route::get('/orders', [OrderController::class, 'listOrders'])->name('orders.index');
});

    // Routes accessible only to admin users
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::post('/orders/{order}/status', [OrderController::class, 'update'])->name('orders.updateStatus');
    Route::patch('/orders/{orderId}/shipped', [OrderController::class, 'markAsShipped'])->name('orders.markAsShipped');
    Route::patch('/orders/{orderId}/delivered', [OrderController::class, 'markAsDelivered'])->name('orders.markAsDelivered');
});

// Route for stripe integration
Route::middleware(['auth'])->group(function(){
    Route::get('/stripe/{total}',[PaymentController::class, 'stripe']);
    Route::post('/stripe/{total}', [PaymentController::class, 'stripePost'])->name('stripe.post');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
