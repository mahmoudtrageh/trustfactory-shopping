<?php

namespace App\Jobs;

use App\Mail\DailySalesReport;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SendDailySalesReport implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Carbon $date
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $orders = Order::with('orderItems')
            ->whereDate('created_at', $this->date)
            ->get();

        $totalOrders = $orders->count();
        $totalRevenue = $orders->sum('total_amount');

        $productsSold = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereDate('orders.created_at', $this->date)
            ->select(
                'order_items.product_name',
                DB::raw('SUM(order_items.quantity) as total_quantity'),
                DB::raw('SUM(order_items.subtotal) as total_revenue')
            )
            ->groupBy('order_items.product_name')
            ->orderByDesc('total_quantity')
            ->get();

        $adminEmail = config('cart.admin_email');

        Mail::to($adminEmail)->send(
            new DailySalesReport($this->date, $totalOrders, $totalRevenue, $productsSold)
        );
    }
}
