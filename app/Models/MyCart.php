<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MyCart extends Model
{
    use SoftDeletes;

    protected $table = 'my_carts';

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity'
    ];

    // ✅ RELATION WITH USER
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ✅ RELATION WITH PRODUCT
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}