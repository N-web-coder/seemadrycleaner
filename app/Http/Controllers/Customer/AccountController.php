<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $recentOrders = Order::where('customer_id', $userId)->latest()->take(5)->get();
        $totalOrders = Order::where('customer_id', $userId)->count();
        $pendingOrders = Order::where('customer_id', $userId)->whereNotIn('status', ['Delivered'])->count();

        return view('frontend.account.dashboard', compact('recentOrders', 'totalOrders', 'pendingOrders'));
    }

    public function orders()
    {
        $orders = Order::where('customer_id', auth()->id())->latest()->paginate(10);
        return view('frontend.account.orders.index', compact('orders'));
    }

    public function showOrder(Order $order)
    {
        if($order->customer_id !== auth()->id()) abort(403);
        
        $order->load(['store', 'items.product', 'items.productOption', 'statusHistories.creator']);
        
        return view('frontend.account.orders.show', compact('order'));
    }
}
