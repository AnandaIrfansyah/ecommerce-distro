<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuksesController extends Controller
{
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
}
