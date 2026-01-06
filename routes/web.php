<?php

use App\Livewire\Checkout;
use App\Livewire\OrderDetails;
use App\Livewire\OrderHistory;
use App\Livewire\ProductList;
use App\Livewire\ShoppingCart;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::get('/products', ProductList::class)->name('products.index');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::view('profile', 'profile')->name('profile');

    Route::get('/cart', ShoppingCart::class)->name('cart');
    Route::get('/checkout', Checkout::class)->name('checkout');
    Route::get('/orders', OrderHistory::class)->name('orders.index');
    Route::get('/orders/{orderId}', OrderDetails::class)->name('orders.show');
});

require __DIR__.'/auth.php';
