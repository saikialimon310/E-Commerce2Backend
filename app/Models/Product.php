<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'product_name',
        'price',
        'discount',
        'avail_count',
        'booked_count',
        'status',
        'image'
    ];

    // ✅ Relationship with images
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    // ✅ Category relation (you already use it)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}