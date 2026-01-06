<?php

namespace App\Livewire;

use App\Models\CartItem;
use Livewire\Attributes\On;
use Livewire\Component;

class ShoppingCart extends Component
{
    #[On('cart-updated')]
    public function refreshCart()
    {
        // This method will trigger a re-render when cart is updated
    }

    public function updateQuantity($cartItemId, $newQuantity)
    {
        $cartItem = CartItem::where('id', $cartItemId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if ($newQuantity <= 0) {
            session()->flash('error', 'Quantity must be at least 1.');

            return;
        }

        if ($newQuantity > $cartItem->product->stock_quantity) {
            session()->flash('error', 'Cannot add more than available stock.');

            return;
        }

        $cartItem->update(['quantity' => $newQuantity]);
        $this->dispatch('cart-updated');
        session()->flash('success', 'Cart updated successfully!');
    }

    public function removeItem($cartItemId)
    {
        $cartItem = CartItem::where('id', $cartItemId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $cartItem->delete();
        $this->dispatch('cart-updated');
        session()->flash('success', 'Item removed from cart!');
    }

    public function render()
    {
        $cartItems = CartItem::with('product')
            ->where('user_id', auth()->id())
            ->get();

        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('livewire.shopping-cart', [
            'cartItems' => $cartItems,
            'total' => $total,
        ])->layout('layouts.app');
    }
}
