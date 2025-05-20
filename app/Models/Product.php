<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'vendor_id', // ensure this is fillable
    ];

    /**
     * Get the vendor (user) that owns the product.
     */
    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    // Product.php
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // vendor
    }

public function orders()
{
    return $this->hasMany(Order::class);
}

public function cart()
{
    return $this->hasMany(Cart::class);
}


public function seller()
{
    return $this->belongsTo(User::class, 'user_id'); // user_id points to the vendor in users table
}

}
