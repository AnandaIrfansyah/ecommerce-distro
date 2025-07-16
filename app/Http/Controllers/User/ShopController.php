<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $categories = Categories::all();

        $products = Product::whereHas('variantsWithStock')
            ->with('category')
            ->when($request->category, function ($query) use ($request) {
                $query->where('category_id', $request->category);
            })
            ->paginate(8);

        return view('pages.user.shop.index', compact('categories', 'products'));
    }
}
