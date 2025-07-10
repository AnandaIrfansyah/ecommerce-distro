<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::latest()->paginate(10);
        return view('pages.admin.color.index', compact('colors'));
    }

    public function create()
    {
        return view('pages.admin.color.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
        ]);

        Color::create($request->only('name'));

        return redirect()->route('color.index')->with('success', 'Warna berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $color = Color::findOrFail($id);
        return view('pages.admin.color.edit', compact('color'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:50',
        ]);

        $color = Color::findOrFail($id);
        $color->update($request->only('name'));

        return redirect()->route('color.index')->with('success', 'Warna berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $color = Color::findOrFail($id);
        $color->delete();

        return redirect()->route('color.index')->with('success', 'Warna berhasil dihapus.');
    }
}
