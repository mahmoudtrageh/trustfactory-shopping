<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;

class OrderHistory extends Component
{
    public function render()
    {
        $orders = Order::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.order-history', [
            'orders' => $orders,
        ])->layout('layouts.app');
    }
}
