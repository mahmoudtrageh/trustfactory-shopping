<?php

namespace Tests\Unit\Models;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_can_be_created(): void
    {
        $product = Product::create([
            'name' => 'Test Product',
            'price' => 99.99,
            'stock_quantity' => 50,
            'description' => 'Test description',
        ]);

        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals('Test Product', $product->name);
        $this->assertEquals(99.99, $product->price);
        $this->assertEquals(50, $product->stock_quantity);
    }

    public function test_is_out_of_stock_returns_true_when_stock_is_zero(): void
    {
        $product = Product::factory()->create(['stock_quantity' => 0]);

        $this->assertTrue($product->isOutOfStock());
    }

    public function test_is_out_of_stock_returns_false_when_stock_is_available(): void
    {
        $product = Product::factory()->create(['stock_quantity' => 10]);

        $this->assertFalse($product->isOutOfStock());
    }

    public function test_is_low_stock_returns_true_when_stock_is_low(): void
    {
        $product = Product::factory()->create(['stock_quantity' => 5]);

        $this->assertTrue($product->isLowStock());
    }

    public function test_is_low_stock_returns_false_when_stock_is_sufficient(): void
    {
        $product = Product::factory()->create(['stock_quantity' => 20]);

        $this->assertFalse($product->isLowStock());
    }

    public function test_is_low_stock_accepts_custom_threshold(): void
    {
        $product = Product::factory()->create(['stock_quantity' => 15]);

        $this->assertTrue($product->isLowStock(20));
        $this->assertFalse($product->isLowStock(10));
    }

    public function test_product_has_cart_items_relationship(): void
    {
        $product = Product::factory()->create();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $product->cartItems());
    }

    public function test_product_has_order_items_relationship(): void
    {
        $product = Product::factory()->create();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $product->orderItems());
    }
}
