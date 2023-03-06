<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index()
    {
        return Order::all();
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'shipping_address_id' => 'required',
            'billing_address_id' => 'required',
            'payment_method' => 'required',
            'status' => 'required',
        ]);

        $order = new Order();
        $order->user_id = $request->user_id;
        $order->shipping_address_id = $request->shipping_address_id;
        $order->billing_address_id = $request->billing_address_id;
        $order->payment_method = $request->payment_method;
        $order->status = $request->status;
        $order->save();

        return redirect()->route('orders.index')->with('success', 'Order created successfully');
    }

    public function show(Order $order)
    {
    }

    public function edit(Order $order)
    {
        Inertia::render('Orders/Edit', [
            'order' => $order,
        ]);
    }

    public function update(Request $request, Order $order)
    {
    }
}