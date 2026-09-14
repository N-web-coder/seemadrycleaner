<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $isSuperAdmin = $user->role === 'admin';
        
        $orderQuery = Order::query();
        if (!$isSuperAdmin) {
            $orderQuery->where('store_id', $user->store_id);
        }
        
        $newOrdersCount = (clone $orderQuery)->where('status', 'Pending')->count();
        $totalRevenue = (clone $orderQuery)->sum('total_amount');
        $totalOrdersCount = (clone $orderQuery)->count();
        $completedOrdersCount = (clone $orderQuery)->where('status', 'Delivered')->count();
        
        return view('dashboard', [
            'newOrders' => $newOrdersCount,
            'totalRevenue' => $totalRevenue,
            'totalOrders' => $totalOrdersCount,
            'completedOrders' => $completedOrdersCount
        ]);
    }
}
