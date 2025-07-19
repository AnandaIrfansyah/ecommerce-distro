<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Addres;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $selectedIds = $request->input('selected_items', []);

        if (empty($selectedIds)) {
            return redirect()->route('cart.index')->withErrors(['checkout' => 'Tidak ada item yang dipilih.']);
        }

        $items = CartItem::with(['product', 'size', 'color'])
            ->where('user_id', $user->id)
            ->whereIn('id', $selectedIds)
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->withErrors(['checkout' => 'Item tidak valid atau tidak ditemukan.']);
        }

        $addresses = Addres::where('user_id', $user->id)->get();

        $subtotal = $items->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('pages.user.checkout.index', [
            'items' => $items,
            'addresses' => $addresses,
            'user' => $user,
            'subtotal' => $subtotal
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'address_id' => 'required|exists:addres,id',
            'selected_items' => 'required|array',
            'shipping_method' => 'required|string|in:hemat,standar,prioritas',
            'payment_method' => 'required|string|in:bank_transfer,e_wallet,cod,store',
            'note' => 'nullable|string',
        ]);

        $shippingFees = [
            'hemat' => 10000,
            'standar' => 20000,
            'prioritas' => 40000,
        ];

        $shippingFee = $shippingFees[$request->shipping_method];

        DB::beginTransaction();

        try {
            $cartItems = CartItem::with(['product', 'size', 'color'])
                ->where('user_id', $user->id)
                ->whereIn('id', $request->selected_items)
                ->get();

            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.index')->withErrors(['checkout' => 'Item tidak ditemukan.']);
            }

            $subtotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
            $total = $subtotal + $shippingFee;

            $order = Order::create([
                'user_id'        => $user->id,
                'address_id'     => $request->address_id,
                'subtotal'       => $subtotal,
                'shipping_fee'   => $shippingFee,
                'total'          => $total,
                'shipping_method' => $request->shipping_method,
                'payment_method' => $request->payment_method,
                'note'           => $request->note,
                'status'         => 'processed',
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'size_id'    => $item->size_id,
                    'color_id'   => $item->color_id,
                    'quantity'   => $item->quantity,
                    'price'      => $item->product->price,
                    'total'      => $item->product->price * $item->quantity,
                ]);
            }

            CartItem::whereIn('id', $request->selected_items)->delete();

            DB::commit();

            return redirect()->route('sukses.index', $order->id)->with('success', 'Pesanan berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal memproses pesanan.']);
        }
    }
}
