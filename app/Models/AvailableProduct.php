<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AvailableProduct extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'user_id',
        'available_quantity',
        'booked_quantity',
        'total_sell_quantity'
        
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
