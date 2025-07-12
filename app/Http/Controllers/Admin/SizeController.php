<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function index()
    {
        $categoriesWithSizes = Categories::with('sizes')->get();
        return view('pages.admin.size.index', compact('categoriesWithSizes'));
    }

    public function create()
    {
        $categories = Categories::all();
        return view('pages.admin.size.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'category_id' => 'nullable|exists:categories,id'
        ]);

        Size::create([
            'name' => $request->name,
            'category_id' => $request->category_id
        ]);

        return redirect()->route('size.index')->with('success', 'Size berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $size = Size::findOrFail($id);
        $categories = Categories::all();
        return view('pages.admin.size.edit', compact('size', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'category_id' => 'nullable|exists:categories,id'
        ]);

        $size = Size::findOrFail($id);
        $size->update([
            'name' => $request->name,
            'category_id' => $request->category_id
        ]);

        return redirect()->route('size.index')->with('success', 'Size berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $size = Size::findOrFail($id);
        $size->delete();

        return redirect()->route('size.index')->with('success', 'Size berhasil dihapus.');
    }
}
