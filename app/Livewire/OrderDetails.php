<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;

class OrderDetails extends Component
{
    public $orderId;

    public function mount($orderId)
    {
        $this->orderId = $orderId;
    }

    public function render()
    {
        $order = Order::with('orderItems')
            ->where('id', $this->orderId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('livewire.order-details', [
            'order' => $order,
        ])->layout('layouts.app');
    }
}
