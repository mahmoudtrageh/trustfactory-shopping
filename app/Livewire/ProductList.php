<?php

namespace App\Livewire;

use App\Models\CartItem;
use App\Models\Product;
use Livewire\Component;

class ProductList extends Component
{
    public function addToCart($productId)
    {
        $product = Product::findOrFail($productId);

        if ($product->isOutOfStock()) {
            session()->flash('error', 'Product is out of stock.');

            return;
        }

        $cartItem = CartItem::where('user_id', auth()->id())
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            if ($cartItem->quantity + 1 > $product->stock_quantity) {
                session()->flash('error', 'Cannot add more than available stock.');

                return;
            }
            $cartItem->increment('quantity');
        } else {
            CartItem::create([
                'user_id' => auth()->id(),
                'product_id' => $productId,
                'quantity' => 1,
            ]);
        }

        $this->dispatch('cart-updated');
        session()->flash('success', 'Product added to cart!');
    }

    public function render()
    {
        return view('livewire.product-list', [
            'products' => Product::all(),
        ]);
    }
}
