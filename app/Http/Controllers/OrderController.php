<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderStatusHistory;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('customer', 'store');
        
        if (auth()->user()->role !== 'admin') {
            $query->where('store_id', auth()->user()->store_id);
        }

        // Filters
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('type')) {
            $query->where('order_type', $request->type);
        }
        if ($request->filled('mobile')) {
            $query->whereHas('customer', function($q) use ($request) {
                $q->where('phone', 'like', '%' . $request->mobile . '%');
            });
        }
        
        $orders = $query->latest()->paginate(15)->withQueryString();
            
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if (auth()->user()->role !== 'admin' && $order->store_id !== auth()->user()->store_id) {
            abort(403);
        }

        $order->load(['customer', 'store', 'coupon', 'items.product', 'items.productOption', 'statusHistories.creator']);
        
        $statuses = ['Pending', 'Pickedup', 'Processing', 'Washed', 'Ironed', 'Ready', 'Delivered'];
        
        return view('admin.orders.show', compact('order', 'statuses'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        if (auth()->user()->role !== 'admin' && $order->store_id !== auth()->user()->store_id) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:Pending,Pickedup,Processing,Washed,Ironed,Ready,Delivered',
            'notes' => 'nullable|string'
        ]);

        if ($order->status !== $request->status) {
            $order->update(['status' => $request->status]);

            OrderStatusHistory::create([
                'order_id' => $order->id,
                'status' => $request->status,
                'notes' => $request->notes ?? 'Status manually updated via admin.',
                'created_by' => auth()->id() ?? null
            ]);
            
            // Trigger Notification Hook
            NotificationService::sendStatusUpdate($order);
            
            return redirect()->route('admin.orders.show', $order)->with('success', 'Order status updated to ' . $request->status);
        }

        return redirect()->route('admin.orders.show', $order)->with('info', 'Order status is already ' . $request->status);
    }
    
    public function printTags(Order $order)
    {
        if (auth()->user()->role !== 'admin' && $order->store_id !== auth()->user()->store_id) {
            abort(403);
        }

        $order->load('items', 'customer');
        return view('admin.orders.print_tags', compact('order'));
    }

    public function getReceipt(Order $order)
    {
        if (auth()->user()->role !== 'admin' && $order->store_id !== auth()->user()->store_id) {
            abort(403);
        }

        $order->load(['customer', 'store', 'items']);
        return view('admin.orders.partials.receipt', compact('order'))->render();
    }
}
