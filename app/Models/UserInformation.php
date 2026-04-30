<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInformation extends Model
{
    protected $table = 'user_informations'; // only needed if table name is custom

    protected $fillable = [
        'user_id',
        'address_line',
        'city',
        'state',
        'pincode',
        'country',
        'latitude',
        'longitude'
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
