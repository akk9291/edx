<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'status',
        'status_locked',
        'total_amount',
        'shipping_charge',
        'cod_charge',
        'coupon_id',
        'coupon_discount',
        'shipping_address',
        'billing_address',
        'payment_method',
        'payment_status',
        'razorpay_order_id',
        'razorpay_payment_id',
        'razorpay_signature',
        'delhivery_waybill',
        'delhivery_data',
        'delhivery_tracking_data',
        'delhivery_cancelled',
        'shiprocket_order_id',
        'shiprocket_shipment_id',
        'shiprocket_awb',
        'shiprocket_data',
        'notes',
        // Legacy fields for backward compatibility
        'customer_name',
        'customer_email',
        'customer_phone',
        'subtotal',
        'tax',
        'shipping',
        'total',
    ];

    protected $casts = [
        'status_locked' => 'boolean',
        'total_amount' => 'decimal:2',
        'shipping_charge' => 'decimal:2',
        'coupon_discount' => 'decimal:2',
        'shipping_address' => 'array',
        'billing_address' => 'array',
        'delhivery_data' => 'array',
        'delhivery_tracking_data' => 'array',
        'delhivery_cancelled' => 'boolean',
        'shiprocket_data' => 'array',
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'shipping' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_number)) {
                // Generate order number: ORD-YYYYMMDD-XXXXXX
                $order->order_number = 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(6));
            }
            
            // Set total_amount from total if not set
            if (empty($order->total_amount) && !empty($order->total)) {
                $order->total_amount = $order->total;
            }
            
            // Set shipping_charge from shipping if not set
            if (empty($order->shipping_charge) && isset($order->shipping)) {
                $order->shipping_charge = $order->shipping;
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the coupon used in this order
     */
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    /**
     * Get order items
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get order items (alias)
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'pending' => 'warning',
            'processing' => 'info',
            'shipped' => 'primary',
            'delivered' => 'success',
            'cancelled' => 'danger',
            default => 'secondary',
        };
    }

    public function getPaymentStatusBadgeClassAttribute()
    {
        return match($this->payment_status) {
            'pending' => 'warning',
            'paid' => 'success',
            'failed' => 'danger',
            'refunded' => 'secondary',
            default => 'secondary',
        };
    }
}
