<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function index()
    {
        $sizes = Size::latest()->paginate(10);
        return view('pages.admin.size.index', compact('sizes'));
    }

    public function create()
    {
        return view('pages.admin.size.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50'
        ]);

        Size::create($request->only('name'));

        return redirect()->route('size.index')->with('success', 'Size berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $size = Size::findOrFail($id);
        return view('pages.admin.size.edit', compact('size'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:50'
        ]);

        $size = Size::findOrFail($id);
        $size->update($request->only('name'));

        return redirect()->route('size.index')->with('success', 'Size berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $size = Size::findOrFail($id);
        $size->delete();

        return redirect()->route('size.index')->with('success', 'Size berhasil dihapus.');
    }
}
