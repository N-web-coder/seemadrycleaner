<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    /**
     * Trigger WhatsApp Notification Hook
     * This is a boilerplate that can be linked to Interakt, WATI, or Meta API.
     */
    public static function sendStatusUpdate(Order $order)
    {
        $phone = $order->customer->phone ?? null;
        $name = $order->customer->name ?? 'Customer';
        
        if (!$phone) {
            Log::warning("Cannot send notification for Order #{$order->order_number}: No phone number found.");
            return;
        }

        $appName = config('app.name');
        $status = $order->status;
        $message = "Hi {$name}, your {$appName} order #{$order->order_number} is now: *{$status}*.";
        
        if ($status === 'Ready') {
            $message .= " \n\n✅ Your clothes are ready for pickup! \n💰 Total Amount: ₹" . number_format($order->total_amount, 2);
        }

        if ($status === 'Delivered') {
            $message .= " \n\n🙏 Thank you for choosing {$appName}. Hope to see you again soon!";
        }

        // --- HOOK INTEGRATION POINT ---
        // You can replace this with your actual WhatsApp provider API call
        // Example (Generic Hook):
        /*
        Http::post('https://your-whatsapp-provider.com/api/send', [
            'apikey' => env('WHATSAPP_API_KEY'),
            'to' => $phone,
            'message' => $message
        ]);
        */

        Log::info("WhatsApp Notification Logged (Placeholder): To: $phone | Msg: $message");
        
        return true;
    }

    public static function sendPaymentLink(Order $order, $paymentLink)
    {
        $phone = $order->customer->phone ?? null;
        $name = $order->customer->name ?? 'Customer';
        
        if (!$phone) return;

        $appName = config('app.name');
        $message = "Hi {$name}, a payment link has been generated for your {$appName} order #{$order->order_number}. \n\n🔗 *Pay Securely Here:* $paymentLink \n\nTotal: ₹" . number_format($order->total_amount, 2);
        
        Log::info("WhatsApp Payment Link Logged (Placeholder): To: $phone | Msg: $message");
        
        return true;
    }

    public static function sendOrderConfirmation(Order $order)
    {
        $phone = $order->customer->phone ?? null;
        $name = $order->customer->name ?? 'Customer';
        
        if (!$phone) return;

        $appName = config('app.name');
        $message = "Hello {$name}! 👋 \nThank you for choosing {$appName}. \n\n📦 *Order #{$order->order_number} has been placed successfully.* \n💰 Total Amount: ₹" . number_format($order->total_amount, 2) . "\n\nWe will notify you once your clothes are processed!";
        
        Log::info("WhatsApp Order Confirmation Logged (Placeholder): To: $phone | Msg: $message");
        
        return true;
    }
}
