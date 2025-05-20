<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['vendor_id', 'user_id', 'rating', 'comment'];

    public function vendor() {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function customer() {
        return $this->belongsTo(User::class, 'user_id');
    }
}


