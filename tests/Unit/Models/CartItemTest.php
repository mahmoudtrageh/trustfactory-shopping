<?php

namespace Tests\Unit\Models;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartItemTest extends TestCase
{
    use RefreshDatabase;

    public function test_cart_item_can_be_created(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['price' => 100.00]);

        $cartItem = CartItem::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $this->assertInstanceOf(CartItem::class, $cartItem);
        $this->assertEquals($user->id, $cartItem->user_id);
        $this->assertEquals($product->id, $cartItem->product_id);
        $this->assertEquals(2, $cartItem->quantity);
    }

    public function test_cart_item_belongs_to_user(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $cartItem = CartItem::factory()->create([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $this->assertInstanceOf(User::class, $cartItem->user);
        $this->assertEquals($user->id, $cartItem->user->id);
    }

    public function test_cart_item_belongs_to_product(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $cartItem = CartItem::factory()->create([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $this->assertInstanceOf(Product::class, $cartItem->product);
        $this->assertEquals($product->id, $cartItem->product->id);
    }

    public function test_subtotal_attribute_calculates_correctly(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['price' => 50.00]);
        $cartItem = CartItem::factory()->create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 3,
        ]);

        $this->assertEquals(150.00, $cartItem->subtotal);
    }

    public function test_unique_constraint_prevents_duplicate_cart_items(): void
    {
        $this->expectException(\Illuminate\Database\UniqueConstraintViolationException::class);

        $user = User::factory()->create();
        $product = Product::factory()->create();

        CartItem::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        CartItem::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);
    }
}
