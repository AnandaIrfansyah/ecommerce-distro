<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuksesController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $orders = Order::with(['items.product', 'items.size', 'items.color'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('status');

        return view('pages.user.order.index', [
            'ordersByStatus' => $orders
        ]);
    }

    public function show($id)
    {
        $user = Auth::user();

        $order = Order::with(['items.product', 'items.size', 'items.color'])
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        return view('pages.user.checkout.success', [
            'order' => $order
        ]);
    }

    public function cancel($id)
    {
        $user = Auth::user();
        $order = Order::where('id', $id)
            ->where('user_id', $user->id)
            ->where('status', 'processed')
            ->firstOrFail();

        $order->status = 'cancelled';
        $order->save();

        return redirect()->route('sukses.index')->with('success', 'Pesanan berhasil dibatalkan.');
    }
}
