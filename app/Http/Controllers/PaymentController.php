<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Razorpay\Api\Api;

class PaymentController extends Controller
{
    public function createPaymentLink(Order $order)
    {
        $store = $order->store;
        $key = $store->razorpay_key ?? env('RAZORPAY_KEY');
        $secret = $store->razorpay_secret ?? env('RAZORPAY_SECRET');

        if (!$key || !$secret) {
            return back()->with('error', 'Razorpay credentials not configured for this store.');
        }

        $api = new Api($key, $secret);

        try {
            $link = $api->paymentLink->create([
                'amount' => $order->total_amount * 100,
                'currency' => 'INR',
                'accept_partial' => false,
                'description' => "Payment for Order #{$order->order_number}",
                'customer' => [
                    'name' => $order->customer->name ?? 'Customer',
                    'contact' => $order->customer->phone ?? ($order->customer->phone ?? '9999999999'),
                    'email' => $order->customer->email ?? 'customer@example.com',
                ],
                'notify' => [
                    'sms' => true,
                    'email' => true,
                ],
                'reminder_enable' => true,
                'notes' => [
                    'order_id' => $order->id,
                ],
                'callback_url' => route('admin.payments.callback'),
                'callback_method' => 'get'
            ]);

            $payment = Payment::create([
                'order_id' => $order->id,
                'transaction_id' => $link->id,
                'payment_gateway' => 'Razorpay',
                'amount' => $order->total_amount,
                'status' => 'pending',
                'payload' => $link->toArray()
            ]);

            // Send WhatsApp Notification with Link
            \App\Services\NotificationService::sendPaymentLink($order, $link->short_url);

            return back()->with('success', 'Payment link generated and sent to customer.');

        } catch (\Exception $e) {
            return back()->with('error', 'Razorpay Error: ' . $e->getMessage());
        }
    }

    public function handleCallback(Request $request)
    {
        $razorpay_payment_id = $request->razorpay_payment_id;
        $razorpay_payment_link_id = $request->razorpay_payment_link_id;
        $razorpay_payment_link_status = $request->razorpay_payment_link_status;

        $payment = Payment::where('transaction_id', $razorpay_payment_link_id)->first();

        if ($payment && $razorpay_payment_link_status === 'paid') {
            $payment->update([
                'status' => 'success',
                'payload' => array_merge($payment->payload ?? [], $request->all())
            ]);

            $order = $payment->order;
            $order->update([
                'payment_status' => 'paid'
            ]);

            return redirect()->route('admin.orders.show', $order)->with('success', 'Payment successful!');
        }

        return redirect()->route('admin.orders.index')->with('error', 'Payment failed or cancelled.');
    }

    public function markAsPaid(Order $order)
    {
        $order->update(['payment_status' => 'paid']);
        
        Payment::create([
            'order_id' => $order->id,
            'payment_gateway' => 'Manual/In-Store',
            'amount' => $order->total_amount,
            'status' => 'success',
            'transaction_id' => 'MANUAL-' . time()
        ]);

        return back()->with('success', 'Order marked as paid manually.');
    }
}
