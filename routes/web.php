<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Models\Order;   


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

// CHECK PREVIOUS ORDERS
Route::get('/previousorders', [OrderController::class, 'previousOrders'])->name('orders.previousOrders');
   
Route::get('/order/confirmation', function() {
    return view('orders.confirmation');
})->name('orders.confirmation');






require __DIR__.'/auth.php';

// ADMIN
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
