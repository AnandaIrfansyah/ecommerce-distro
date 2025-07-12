<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Categories::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function colors()
    {
        return $this->hasManyThrough(Color::class, ProductVariant::class, 'product_id', 'id', 'id', 'color_id')->distinct();
    }

    public function sizes()
    {
        return $this->hasManyThrough(Size::class, ProductVariant::class, 'product_id', 'id', 'id', 'size_id')->distinct();
    }
    public function variantsWithStock()
    {
        return $this->hasMany(ProductVariant::class)->where('stock', '>', 0);
    }
}
