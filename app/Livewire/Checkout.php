<?php

namespace App\Livewire;

use App\Models\CartItem;
use App\Services\CheckoutService;
use Livewire\Component;

class Checkout extends Component
{
    public function mount()
    {
        $cartItems = CartItem::where('user_id', auth()->id())->count();

        if ($cartItems === 0) {
            session()->flash('error', 'Your cart is empty.');

            return redirect()->route('products.index');
        }
    }

    public function placeOrder(CheckoutService $checkoutService)
    {
        try {
            $order = $checkoutService->processCheckout(auth()->id());

            $this->dispatch('cart-updated');

            session()->flash('success', "Order placed successfully! Order number: {$order->order_number}");

            return redirect()->route('orders.show', $order->id);
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function render()
    {
        $cartItems = CartItem::with('product')
            ->where('user_id', auth()->id())
            ->get();

        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('livewire.checkout', [
            'cartItems' => $cartItems,
            'total' => $total,
        ])->layout('layouts.app');
    }
}
