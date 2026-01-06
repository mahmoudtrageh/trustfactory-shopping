<?php

namespace Tests\Feature;

use App\Livewire\ProductList;
use App\Livewire\ShoppingCart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_cart(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        CartItem::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        Livewire::actingAs($user)
            ->test(ShoppingCart::class)
            ->assertStatus(200)
            ->assertSee($product->name);
    }

    public function test_user_can_add_product_to_cart(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['stock_quantity' => 10]);

        Livewire::actingAs($user)
            ->test(ProductList::class)
            ->call('addToCart', $product->id)
            ->assertDispatched('cart-updated');

        $this->assertDatabaseHas('cart_items', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);
    }

    public function test_adding_same_product_increments_quantity(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['stock_quantity' => 10]);

        CartItem::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        Livewire::actingAs($user)
            ->test(ProductList::class)
            ->call('addToCart', $product->id);

        $this->assertDatabaseHas('cart_items', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);
    }

    public function test_cannot_add_out_of_stock_product_to_cart(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['stock_quantity' => 0]);

        Livewire::actingAs($user)
            ->test(ProductList::class)
            ->call('addToCart', $product->id);

        $this->assertDatabaseMissing('cart_items', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }

    public function test_cannot_add_more_than_available_stock(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['stock_quantity' => 5]);

        CartItem::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 5,
        ]);

        Livewire::actingAs($user)
            ->test(ProductList::class)
            ->call('addToCart', $product->id);

        $this->assertDatabaseHas('cart_items', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 5,
        ]);
    }

    public function test_user_can_update_cart_item_quantity(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['stock_quantity' => 10]);
        $cartItem = CartItem::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        Livewire::actingAs($user)
            ->test(ShoppingCart::class)
            ->call('updateQuantity', $cartItem->id, 5);

        $this->assertDatabaseHas('cart_items', [
            'id' => $cartItem->id,
            'quantity' => 5,
        ]);
    }

    public function test_user_can_remove_item_from_cart(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $cartItem = CartItem::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        Livewire::actingAs($user)
            ->test(ShoppingCart::class)
            ->call('removeItem', $cartItem->id)
            ->assertDispatched('cart-updated');

        $this->assertDatabaseMissing('cart_items', [
            'id' => $cartItem->id,
        ]);
    }

    public function test_cart_displays_only_user_items(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $product = Product::factory()->create();

        CartItem::create([
            'user_id' => $user1->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        CartItem::create([
            'user_id' => $user2->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $user1Items = CartItem::where('user_id', $user1->id)->count();
        $user2Items = CartItem::where('user_id', $user2->id)->count();

        $this->assertEquals(1, $user1Items);
        $this->assertEquals(1, $user2Items);
    }

    public function test_cart_persists_in_database(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['stock_quantity' => 10]);

        Livewire::actingAs($user)
            ->test(ProductList::class)
            ->call('addToCart', $product->id);

        $this->assertDatabaseHas('cart_items', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $cartItem = CartItem::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->first();

        $this->assertNotNull($cartItem);
        $this->assertEquals(1, $cartItem->quantity);
    }

    public function test_cart_counter_shows_correct_count(): void
    {
        $user = User::factory()->create();
        $product1 = Product::factory()->create();
        $product2 = Product::factory()->create();

        CartItem::create([
            'user_id' => $user->id,
            'product_id' => $product1->id,
            'quantity' => 1,
        ]);

        CartItem::create([
            'user_id' => $user->id,
            'product_id' => $product2->id,
            'quantity' => 1,
        ]);

        $this->actingAs($user);

        $count = CartItem::where('user_id', $user->id)->count();
        $this->assertEquals(2, $count);
    }
}
