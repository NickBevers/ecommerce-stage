<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'order_status' => 'required',
        ]);

        $order->update([
            'order_status' => $request->order_status,
        ]);

        return redirect()->route('orders.show', $order->id);
    }
}