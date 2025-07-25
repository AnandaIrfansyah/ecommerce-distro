<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'address_id',
        'subtotal',
        'shipping_fee',
        'total',
        'shipping_method',
        'payment_method',
        'note',
        'status',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Addres::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
