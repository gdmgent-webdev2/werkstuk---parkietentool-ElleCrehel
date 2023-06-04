<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MoneyController;
use App\Http\Controllers\WebhookController;
use App\Models\Order;
use Faker\Provider\ar_EG\Payment;
use Money\Money;

// HOME
Route::get('/', [HomeController::class, 'home'])->name('pages.home');
Route::get('/order', [OrderController::class, 'view'])->name('orders.order');

// NOT LOGGED IN
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// PROFILE
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ORDER RING
Route::post('/order', [OrderController::class, 'create'])->name('orders.create');
//PAYMENT RING
ROUTE::post('/order', [OrderController::class, 'earn'])->name('orders.earn');

// CHECK PREVIOUS ORDERS
Route::get('/previousorders', [OrderController::class, 'previousOrders'])->name('orders.previousOrders');
   
Route::get('/order/confirmation', function() {
    return view('orders.confirmation');
})->name('orders.confirmation');


// PAYMENT
ROUTE::get('/payment', [Moneycontroller::class, 'index'])->name('money.index');
ROUTE::post('/payment', [Moneycontroller::class, 'earn'])->name('money.earn');
ROUTE::get('/payment/succes',[Moneycontroller::class, 'succes'])->name('orders.confirmation');



// WEBHOOK
ROUTE::post('/webhooks/mollie', [WebhookController::class, 'mollie'])->name('webhooks.mollie');


require __DIR__.'/auth.php';

// ADMIN
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
