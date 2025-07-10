<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Categories::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $kategoris = $query->latest()->paginate(10);

        return view('pages.admin.category.index', compact('kategoris'));
    }

    public function create()
    {
        return view('pages.admin.category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'icon' => 'required|string|max:255',
            'name' => 'required|string|max:255'
        ]);

        Categories::create($request->only('icon', 'name'));

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kategori = Categories::findOrFail($id);
        return view('pages.admin.category.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'icon' => 'required|string|max:255',
            'name' => 'required|string|max:255'
        ]);

        $kategori = Categories::findOrFail($id);
        $kategori->update($request->only('icon', 'name'));

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kategori = Categories::findOrFail($id);
        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
