<?php

namespace App\Services;

use App\Jobs\SendLowStockNotification;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class CheckoutService
{
    public function processCheckout($userId)
    {
        return DB::transaction(function () use ($userId) {
            $cartItems = CartItem::with('product')
                ->where('user_id', $userId)
                ->get();

            if ($cartItems->isEmpty()) {
                throw new \Exception('Cart is empty.');
            }

            foreach ($cartItems as $cartItem) {
                if ($cartItem->product->isOutOfStock()) {
                    throw new \Exception("Product '{$cartItem->product->name}' is out of stock.");
                }

                if ($cartItem->quantity > $cartItem->product->stock_quantity) {
                    throw new \Exception("Insufficient stock for '{$cartItem->product->name}'.");
                }
            }

            $total = $cartItems->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });

            $order = Order::create([
                'user_id' => $userId,
                'order_number' => Order::generateOrderNumber(),
                'total_amount' => $total,
                'status' => 'pending',
            ]);

            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'product_name' => $cartItem->product->name,
                    'quantity' => $cartItem->quantity,
                    'unit_price' => $cartItem->product->price,
                    'subtotal' => $cartItem->product->price * $cartItem->quantity,
                ]);

                $cartItem->product->decrement('stock_quantity', $cartItem->quantity);

                if ($cartItem->product->fresh()->isLowStock(config('cart.low_stock_threshold', 10))) {
                    SendLowStockNotification::dispatch($cartItem->product);
                }
            }

            CartItem::where('user_id', $userId)->delete();

            return $order;
        });
    }
}
