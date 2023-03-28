<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function update(Request $request, Int $id)
    {
        $request->validate([
            'order_status' => 'required',
        ]);

        $order = Order::find($id);
        $order->update([
            'order_status' => $request->order_status,
        ]);

        return redirect()->route('orders.show', $order->id);
    }
}