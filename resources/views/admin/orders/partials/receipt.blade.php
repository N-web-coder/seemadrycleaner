<div id="printableReceipt" style="width: 100%; font-family: 'Courier New', Courier, monospace; font-size: 13px; color: #000; padding: 10px; background: #fff;">
    <div style="text-align: center; border-bottom: 2px solid #000; padding-bottom: 15px; margin-bottom: 15px;">
        <h3 style="margin: 0; font-size: 20px;">{{ strtoupper(config('app.name')) }}</h3>
        <p style="margin: 5px 0;">{{ $order->store->name ?? 'Main Branch' }}</p>
        <div style="font-size: 11px; margin-top: 5px;">
            ORDER: <strong>#{{ $order->order_number }}</strong><br>
            DATE: {{ $order->created_at->format('d/m/Y h:i A') }}
        </div>
    </div>

    <div style="margin-bottom: 15px;">
        <p style="margin: 0;">CUSTOMER: {{ $order->customer->name ?? 'Walk-in' }} ({{ $order->customer->phone ?? $order->customer_phone ?? 'N/A' }})</p>
    </div>

    <table style="width: 100%; border-collapse: collapse; margin-bottom: 15px;">
        <thead>
            <tr style="border-bottom: 1px solid #000;">
                <th style="text-align: left; padding: 5px 0;">Item</th>
                <th style="text-align: center; padding: 5px 0;">Qty</th>
                <th style="text-align: right; padding: 5px 0;">Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td style="padding: 5px 0;">
                        {{ $item->product_name }}
                        @if($item->option_name)
                            <br><small style="color:#555;">+ {{ $item->option_name }}</small>
                        @endif
                    </td>
                    <td style="text-align: center; padding: 5px 0;">{{ $item->quantity }}</td>
                    <td style="text-align: right; padding: 5px 0;">₹{{ number_format($item->total_price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="border-top: 1px solid #000; padding-top: 10px;">
        <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
            <span>Subtotal:</span>
            <span>₹{{ number_format($order->sub_total, 2) }}</span>
        </div>
        @if($order->discount_amount > 0)
            <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                <span>Discount:</span>
                <span>-₹{{ number_format($order->discount_amount, 2) }}</span>
            </div>
        @endif
        <div style="display: flex; justify-content: space-between; font-weight: bold; font-size: 16px; margin-top: 10px; border-top: 2px solid #000; padding-top: 5px;">
            <span>TOTAL:</span>
            <span>₹{{ number_format($order->total_amount, 2) }}</span>
        </div>
    </div>

    <div style="text-align: center; margin-top: 30px; border-top: 1px dashed #555; padding-top: 15px;">
        <p style="margin: 0; font-size: 11px;">Thank you for your choice!</p>
        <p style="margin: 5px 0 0; font-size: 10px;">Please keep this receipt for pickup.</p>
        <div style="margin-top: 10px;">
            {!! DNS1D::getBarcodeHTML($order->order_number, 'C128', 1, 30) !!}
        </div>
    </div>
</div>
