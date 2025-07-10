<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Size;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    public function index()
    {
        $variants = ProductVariant::with(['product', 'size', 'color'])->latest()->paginate(10);
        return view('pages.admin.productVariant.index', compact('variants'));
    }

    public function create()
    {
        $products = Product::all();
        $colors = Color::all();
        $sizes = Size::all();

        return view('pages.admin.productVariant.create', compact('products', 'colors', 'sizes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'size_id' => 'required|exists:sizes,id',
            'color_id' => 'required|exists:colors,id',
            'stock' => 'required|integer|min:0'
        ]);

        ProductVariant::create($request->all());

        return redirect()->route('productVariant.index')->with('success', 'Varian produk berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $variant = ProductVariant::findOrFail($id);
        $products = Product::all();
        $colors = Color::all();
        $sizes = Size::all();

        return view('pages.admin.productVariant.edit', compact('variant', 'products', 'colors', 'sizes'));
    }

    public function update(Request $request, $id)
    {
        $variant = ProductVariant::findOrFail($id);

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'size_id' => 'required|exists:sizes,id',
            'color_id' => 'required|exists:colors,id',
            'stock' => 'required|integer|min:0'
        ]);

        $variant->update($request->all());

        return redirect()->route('productVariant.index')->with('success', 'Varian produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $variant = ProductVariant::findOrFail($id);
        $variant->delete();

        return redirect()->route('productVariant.index')->with('success', 'Varian produk berhasil dihapus.');
    }
}
