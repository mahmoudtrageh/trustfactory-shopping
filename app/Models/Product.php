<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'stock_quantity',
        'description',
        'image',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock_quantity' => 'integer',
    ];

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function isLowStock($threshold = 5)
    {
        return $this->stock_quantity <= $threshold && $this->stock_quantity > 0;
    }

    public function isOutOfStock()
    {
        return $this->stock_quantity <= 0;
    }
}
