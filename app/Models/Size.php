<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $fillable = ['category_id', 'name'];

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
    public function category()
    {
        return $this->belongsTo(Categories::class);
    }
}
