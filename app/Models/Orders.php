<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Orders extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'name',
        'email',
        'phone',
        'address',
        'city',
        'postal_code',
        'payment_type',
        'payment_method',
        'transaction_id',
        'currency',
        'amount',
        'coupon_discount',
        'shipping_charge',
        'invoice_no',
        'order_date',
        'order_month',
        'order_year',
        'confirmed_date',
        'processing_date',
        'picked_date',
        'shipped_date',
        'delivered_date',
        'cancel_date',
        'return_date',
        'return_reason',
        'status'
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItems::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
