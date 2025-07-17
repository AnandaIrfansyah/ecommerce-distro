<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Addres;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlamatController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $addresses = Addres::where('user_id', Auth::id())->get();
        return view('pages.user.alamat.index', compact('addresses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'province' => 'required',
            'city' => 'required',
            'kecamatan' => 'required',
            'postal_code' => 'required',
            'address_line1' => 'required',
        ]);

        if ($request->has('is_default')) {
            Addres::where('user_id', Auth::id())->update(['is_default' => false]);
        }

        Addres::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'phone' => $request->phone,
            'province' => $request->province,
            'city' => $request->city,
            'kecamatan' => $request->kecamatan,
            'postal_code' => $request->postal_code,
            'address_line1' => $request->address_line1,
            'is_default' => $request->has('is_default'),
        ]);

        return redirect()->route('addres.index')->with('success', 'Alamat berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $address = Addres::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'province' => 'required',
            'city' => 'required',
            'kecamatan' => 'required',
            'postal_code' => 'required',
            'address_line1' => 'required',
        ]);

        $isDefault = $request->has('is_default');

        if ($isDefault) {
            Addres::where('user_id', Auth::id())->update(['is_default' => false]);
        }

        $address->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'province' => $request->province,
            'city' => $request->city,
            'kecamatan' => $request->kecamatan,
            'postal_code' => $request->postal_code,
            'address_line1' => $request->address_line1,
            'is_default' => $isDefault,
        ]);

        return redirect()->route('addres.index')->with('success', 'Alamat berhasil diperbarui.');
    }



    public function destroy(Addres $address)
    {
        $this->authorize('delete', $address);

        $address->delete();
        return redirect()->route('addres.index')->with('success', 'Alamat berhasil dihapus.');
    }
}
