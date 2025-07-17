<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Addres extends Model
{
    protected $table = 'addres';

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'province',
        'city',
        'kecamatan',
        'postal_code',
        'address_line1',
        'country',
        'is_default',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
