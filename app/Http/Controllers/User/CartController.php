<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $cartItems = CartItem::with(['product', 'size', 'color'])
            ->where('user_id', $userId)
            ->get();

        return view('pages.user.cart.index', compact('cartItems'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'size_id' => 'nullable|exists:sizes,id',
            'color_id' => 'nullable|exists:colors,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $user = Auth::user();

        $product = Product::with('variants')->findOrFail($request->product_id);

        $availableStock = $product->variants
            ->filter(function ($variant) use ($request) {
                return (!$request->size_id || $variant->size_id == $request->size_id) &&
                    (!$request->color_id || $variant->color_id == $request->color_id);
            })
            ->sum('stock');

        if ($request->quantity > $availableStock) {
            return back()->withErrors(['quantity' => 'Jumlah melebihi stok yang tersedia.']);
        }

        $cartItem = CartItem::where('user_id', $user->id)
            ->where('product_id', $request->product_id)
            ->where('size_id', $request->size_id)
            ->where('color_id', $request->color_id)
            ->first();

        if ($cartItem) {
            $newQty = $cartItem->quantity + $request->quantity;

            if ($newQty > $availableStock) {
                return back()->withErrors(['quantity' => 'Total item di keranjang melebihi stok yang tersedia.']);
            }

            $cartItem->increment('quantity', $request->quantity);
        } else {
            CartItem::create([
                'user_id' => $user->id,
                'product_id' => $request->product_id,
                'size_id' => $request->size_id,
                'color_id' => $request->color_id,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }


    public function remove($id)
    {
        $user = Auth::user();

        $cartItem = CartItem::where('id', $id)->where('user_id', $user->id)->first();

        if (!$cartItem) {
            return redirect()->route('cart.index')->with('error', 'Item tidak ditemukan atau tidak memiliki akses.');
        }

        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Item berhasil dihapus dari keranjang.');
    }

    public function updateQuantity(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:cart_items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $item = \App\Models\CartItem::find($request->id);
        $item->quantity = $request->quantity;
        $item->save();

        return back()->with('success', 'Quantity berhasil diubah.');
    }
}
