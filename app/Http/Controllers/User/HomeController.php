<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Categories::all();
        $products = Product::whereHas('variantsWithStock')
            ->with('category')
            ->take(8)
            ->get();

        return view('pages.user.home', compact('categories', 'products'));
    }


    public function byCategory($id)
    {
        $category = Categories::findOrFail($id);
        $products = Product::where('category_id', $id)
            ->whereHas('variantsWithStock')
            ->with('variants')
            ->get();
        return view('pages.user.filter.index', compact('products', 'category'));
    }
}
