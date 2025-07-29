<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'items.product', 'items.color', 'items.size', 'address'])
            ->latest()
            ->paginate(10); 

        return view('pages.admin.pesanan.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['user', 'items.product', 'items.color', 'items.size', 'address'])
            ->findOrFail($id);

        return view('pages.admin.pesanan.show', compact('order'));
    }
}
