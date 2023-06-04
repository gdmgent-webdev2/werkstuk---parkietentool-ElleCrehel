<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MoneyController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\EigendomsbewijzenController;
use App\Models\Order;
use Faker\Provider\ar_EG\Payment;
use Money\Money;

// HOME
Route::get('/', [HomeController::class, 'home'])->name('pages.home');
Route::get('/order', [OrderController::class, 'view'])->name('orders.order');

// DASHBOARD
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// PROFILE
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // PAY MEMBERSHIP FEE

    Route::post('/profile/payment/checkout', [ProfileController::class, 'payMembershipFee'])->name('profile.payment.checkout');
    Route::get('/profile/payment/confirmation', [ProfileController::class, 'paymentConfirmation'])->name('profile.payment.confirmation');
});

// ORDER RING
Route::post('/order', [OrderController::class, 'store'])->name('orders.store');

Route::get('/orders/membership-alert', [OrderController::class, 'showMembershipAlert'])->name('orders.membership.alert');

// CHECK PREVIOUS ORDERS
Route::get('/previousorders', [OrderController::class, 'previousOrders'])->name('orders.previousOrders');

//EIGENDOMSBEWIJZEN
Route::get('/eigendomsbewijzen', [EigendomsbewijzenController::class, 'index'])->name('orders.eigendomsbewijzen');

Route::get('/order/confirmation', function () {
    return view('orders.confirmation');
})->name('orders.confirmation');



// WEBHOOK
ROUTE::post('/webhooks/mollie', [WebhookController::class, 'mollie'])->name('webhooks.mollie');


require __DIR__ . '/auth.php';

// ADMIN
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
