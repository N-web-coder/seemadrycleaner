<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number', 'customer_id', 'store_id', 'order_type', 'status',
        'sub_total', 'coupon_id', 'discount_amount', 'delivery_charge', 'tax_amount',
        'total_amount', 'payment_method', 'payment_status', 'pickup_address_id',
        'delivery_address_id', 'remarks'
    ];

    public function customer() {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function store() {
        return $this->belongsTo(Store::class);
    }

    public function coupon() {
        return $this->belongsTo(Coupon::class);
    }

    public function items() {
        return $this->hasMany(OrderItem::class);
    }

    public function statusHistories() {
        return $this->hasMany(OrderStatusHistory::class);
    }

    public function payments() {
        return $this->hasMany(Payment::class);
    }
}
