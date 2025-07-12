<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $fillable = ['icon', 'name'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function sizes()
    {
        return $this->hasMany(Size::class, 'category_id');
    }
}
