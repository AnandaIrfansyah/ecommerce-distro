<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $selectedIds = $request->input('selected_items', []);

        if (empty($selectedIds)) {
            return back()->with('error', 'Silakan pilih item yang ingin di-checkout.');
        }

        $cartItems = CartItem::whereIn('id', $selectedIds)
            ->where('user_id', Auth::id())
            ->with(['product', 'size', 'color'])
            ->get();

        return view('pages.user.checkout.index', ['selectedItems' => $cartItems]);
    }
}
