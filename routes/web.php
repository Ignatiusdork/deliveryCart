<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PaymentService;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;

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

Route::middleware(['auth'])->group(function () {
    Route::get('/account/overview/{id}', [UserController::class, 'accountOverview'])->name('account.overview');

    Route::get('/invoices/{invoiceId}/download', [OrderController::class, 'downloadInvoice'])->name('invoices.download');
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

//Route for tickets
Route::middleware(['auth'])->group(function () {
    //Route::resource('tickets', TicketController::class)->except(['edit']);

    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets/store', [TicketController::class, 'store'])->name('tickets.store');

    Route::get('/tickets/{ticketId}', [TicketController::class, 'show'])->name('tickets.show');
    Route::post('/tickets/{ticketId}/reply', [TicketController::class, 'reply'])->name('tickets.reply');

    Route::post('/tickets/{ticketId}/status', [TicketController::class, 'updateStatus'])->name('tickets.update-status');
    Route::post('/tickets/{ticketId}/close', [TicketController::class, 'close'])->name('tickets.close');
    Route::get('/tickets/statuses', [TicketController::class, 'getStatuses'])->name('tickets.statuses');
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
