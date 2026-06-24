<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MyOrder extends Model
{
    use SoftDeletes;

    protected $table = 'my_orders';

    protected $fillable = [
        'user_id',
        'seller_id',
        'product_id',
        'quantity',
        'delivery_address',
        'delivery_phone_no',
        'price',
        'total_price',
        'status',
        'payment_mode',
        'order_date',
        'order_confirmed_at',
        'expected_delivery_date',
        'delivery_date',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'order_date' => 'datetime',
        'order_confirmed_at' => 'datetime',
        'expected_delivery_date' => 'date',
        'delivery_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}
