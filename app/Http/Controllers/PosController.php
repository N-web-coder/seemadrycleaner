<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Str;

class PosController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)->get();
        // Eager load options so POS has all data instantly for modal
        $products = Product::with('options')->where('is_active', true)->get();
        
        $user = auth()->user();
        if ($user->role === 'admin') {
            $stores = Store::where('is_active', true)->get();
        } else {
            $stores = Store::where('id', $user->store_id)->get();
        }
        
        return view('admin.pos.index', compact('categories', 'products', 'stores'));
    }

    public function validateCoupon(Request $request)
    {
        $code = strtoupper($request->code);
        $subTotal = (float) $request->sub_total;

        $coupon = Coupon::where('code', $code)->where('is_active', true)->first();

        if (!$coupon) {
            return response()->json(['error' => 'Invalid or inactive coupon'], 400);
        }

        if ($coupon->valid_from && now()->lt(\Carbon\Carbon::parse($coupon->valid_from))) {
            return response()->json(['error' => 'Coupon is not active yet'], 400);
        }

        if ($coupon->valid_until && now()->gt(\Carbon\Carbon::parse($coupon->valid_until)->endOfDay())) {
            return response()->json(['error' => 'Coupon has expired'], 400);
        }

        if ($subTotal < $coupon->min_order_amount) {
            return response()->json(['error' => 'Minimum order amount of ₹' . number_format($coupon->min_order_amount, 2) . ' not met'], 400);
        }

        $discountLabel = '';
        $discountAmount = 0;
        
        if ($coupon->type == 'percent') {
            $discountLabel = $coupon->value . '% off';
            $discountAmount = ($subTotal * $coupon->value) / 100;
            if ($coupon->max_discount_amount && $discountAmount > $coupon->max_discount_amount) {
                $discountAmount = $coupon->max_discount_amount;
            }
        } else {
            $discountLabel = '₹' . number_format($coupon->value, 2) . ' off';
            $discountAmount = $coupon->value;
            if ($discountAmount > $subTotal) {
                $discountAmount = $subTotal;
            }
        }

        return response()->json([
            'coupon_id' => $coupon->id,
            'code' => $coupon->code,
            'discount_amount' => $discountAmount,
            'label' => $discountLabel
        ]);
    }

    public function findCustomer(Request $request)
    {
        $phone = $request->phone;
        if (!$phone) {
            return response()->json(['error' => 'Phone number provided is empty'], 400);
        }

        $user = \App\Models\User::where('phone', $phone)->where('role','customer')->first();
        
        if ($user) {
            return response()->json(['name' => $user->name, 'email' => $user->email]);
        }

        return response()->json(['error' => 'Customer not found'], 404);
    }

    public function storeOrder(Request $request)
    {
        $request->validate([
            'store_id' => 'required|exists:stores,id',
            'order_type' => 'required|in:online,phone,instore,whatsapp',
            'items' => 'required|array|min:1',
            'items.*.pId' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.unitPrice' => 'required|numeric|min:0'
        ]);

        \DB::beginTransaction();
        try {
            $customerId = null;
            if ($request->customer_phone) {
                $user = \App\Models\User::firstOrCreate(
                    ['phone' => $request->customer_phone],
                    [
                        'name' => $request->customer_name ?: 'Walkin Customer',
                        'email' => $request->customer_phone . '@seema.test',
                        'password' => \Hash::make(\Illuminate\Support\Str::random(12)),
                        'role' => 'customer'
                    ]
                );
                $customerId = $user->id;
            }

            $subTotal = 0;
            foreach ($request->items as $item) {
                $subTotal += ($item['qty'] * $item['unitPrice']);
            }

            $discountAmount = 0;
            $couponId = null;

            if ($request->coupon_id) {
                $coupon = Coupon::find($request->coupon_id);
                if ($coupon && $subTotal >= $coupon->min_order_amount && $coupon->is_active) {
                    $couponId = $coupon->id;
                    if ($coupon->type == 'percent') {
                        $discountAmount = ($subTotal * $coupon->value) / 100;
                        if ($coupon->max_discount_amount && $discountAmount > $coupon->max_discount_amount) {
                            $discountAmount = $coupon->max_discount_amount;
                        }
                    } else {
                        $discountAmount = $coupon->value;
                        if ($discountAmount > $subTotal) {
                            $discountAmount = $subTotal;
                        }
                    }
                }
            }

            $totalAmount = max(0, $subTotal - $discountAmount);
            
            

            $storeId = $request->store_id;
            if (auth()->user()->role !== 'admin') {
                $storeId = auth()->user()->store_id;
            }

            $orderNumber = $storeId.'-'. Carbon::now()->format('Ymd').Str::upper(Str::random(4));

            $order = \App\Models\Order::create([
                'order_number' => $orderNumber,
                'customer_id' => $customerId,
                'store_id' => $storeId,
                'order_type' => $request->order_type,
                'status' => 'Pending',
                'sub_total' => $subTotal,
                'coupon_id' => $couponId,
                'discount_amount' => $discountAmount,
                'delivery_charge' => 0,
                'tax_amount' => 0,
                'total_amount' => $totalAmount,
                'payment_method' => 'cod',
                'payment_status' => 'pending'
            ]);

            \App\Models\OrderStatusHistory::create([
                'order_id' => $order->id,
                'status' => 'Pending',
                'notes' => 'Order placed via POS terminal.',
                'created_by' => auth()->id() ?? null
            ]);

            foreach ($request->items as $idx => $item) {
                $totalPrice = $item['qty'] * $item['unitPrice'];
                $itemTag = $order->id . '-' . str_pad($idx + 1, 2, '0', STR_PAD_LEFT);

                \App\Models\OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['pId'],
                    'product_name' => $item['pName'],
                    'product_option_id' => isset($item['optId']) && $item['optId'] ? $item['optId'] : null,
                    'option_name' => $item['optName'] ?? null,
                    'quantity' => $item['qty'],
                    'unit_price' => $item['unitPrice'],
                    'total_price' => $totalPrice,
                    'remarks' => $item['remarks'] ?? null,
                    'tag_auto' => $itemTag
                ]);
            }

            \DB::commit();

            // Send Confirmation Notification
            \App\Services\NotificationService::sendOrderConfirmation($order);

            return response()->json([
                'success' => true,
                'order_number' => $order->order_number,
                'order_id' => $order->id
            ]);

        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
