<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Store;
use App\Models\OrderStatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if(count($cart) == 0) return redirect()->route('categories.index')->with('warning', 'Your basket is empty.');
        
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $stores = Store::where('is_active', true)->get();
        return view('frontend.checkout.index', compact('cart', 'total', 'stores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'store_id' => 'required|exists:stores,id',
            'payment_method' => 'required|in:cod,online',
            'address' => 'required|string',
            'city' => 'required|string',
            'phone' => 'required|string',
        ]);

        $cart = session()->get('cart', []);
        if(count($cart) == 0) return redirect()->route('categories.index');

        $subTotal = 0;
        foreach($cart as $item) {
            $subTotal += $item['price'] * $item['quantity'];
        }

        // Apply any global settings here (delivery charge, tax) - keeping it simple for now
        $deliveryCharge = 0; 
        $taxAmount = 0;
        $totalAmount = $subTotal + $deliveryCharge + $taxAmount;

        DB::beginTransaction();
        try {
            // New order number format as requested previously: StoreID-Date-Random4
            $orderNumber = $request->store_id . '-' . now()->format('Ymd') . strtoupper(\Str::random(4));

            $order = Order::create([
                'order_number' => $orderNumber,
                'customer_id' => auth()->id(),
                'store_id' => $request->store_id,
                'order_type' => 'online',
                'status' => 'Pending',
                'sub_total' => $subTotal,
                'delivery_charge' => $deliveryCharge,
                'tax_amount' => $taxAmount,
                'total_amount' => $totalAmount,
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'delivery_address_id' => null, // We'll store address as text for simplicity now or expand later
                'remarks' => "Address: " . $request->address . ", City: " . $request->city . ", Phone: " . $request->phone,
            ]);

            $i = 1;
            foreach($cart as $item) {
                $itemTag = $order->id . '-' . str_pad($i++, 2, '0', STR_PAD_LEFT);
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_name' => $item['name'], // Snapshot name
                    'product_option_id' => $item['option_id'],
                    'option_name' => $item['option_name'], // Snapshot option
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'total_price' => $item['price'] * $item['quantity'],
                    'remarks' => $item['remarks'],
                    'tag_auto' => $itemTag
                ]);
            }

            OrderStatusHistory::create([
                'order_id' => $order->id,
                'status' => 'Pending',
                'notes' => 'Order placed online by customer.',
                'created_by' => auth()->id()
            ]);

            DB::commit();
            
            // Clear Cart
            session()->forget('cart');

            // Send Confirmation Notification
            NotificationService::sendOrderConfirmation($order);

            return redirect()->route('checkout.success', $order->id);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getTraceAsString());
            return back()->with('error', 'Checkout failed: ' . $e->getMessage());
        }
    }

    public function success(Order $order)
    {
        // Simple security check
        if($order->customer_id !== auth()->id()) abort(403);
        
        return view('frontend.checkout.success', compact('order'));
    }
}
