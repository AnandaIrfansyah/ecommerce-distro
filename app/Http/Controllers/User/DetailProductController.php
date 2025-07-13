<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Product;
use Illuminate\Http\Request;

class DetailProductController extends Controller
{
    public function show($id)
    {
        $product = Product::with(['category', 'variants.size', 'variants.color'])->findOrFail($id);

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->whereHas('variantsWithStock')
            ->take(6)
            ->get();

        $categories = Categories::withCount('products')->get();

        return view('pages.user.detail.index', compact('product', 'relatedProducts', 'categories'));
    }
}
