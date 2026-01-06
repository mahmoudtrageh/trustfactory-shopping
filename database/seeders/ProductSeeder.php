<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Laptop Pro 15"',
                'price' => 999.99,
                'stock_quantity' => 50,
                'description' => 'High-performance laptop with 16GB RAM and 512GB SSD',
            ],
            [
                'name' => 'Wireless Mouse',
                'price' => 29.99,
                'stock_quantity' => 100,
                'description' => 'Ergonomic wireless mouse with precision tracking',
            ],
            [
                'name' => 'Mechanical Keyboard',
                'price' => 79.99,
                'stock_quantity' => 3,
                'description' => 'RGB mechanical keyboard with blue switches',
            ],
            [
                'name' => 'USB-C Hub',
                'price' => 49.99,
                'stock_quantity' => 0,
                'description' => '7-in-1 USB-C hub with HDMI, USB 3.0, and SD card reader',
            ],
            [
                'name' => '27" Monitor',
                'price' => 299.99,
                'stock_quantity' => 25,
                'description' => '4K UHD monitor with HDR support',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
