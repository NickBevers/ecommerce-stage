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

    public function getOrdersByUser()
    {
        $orders = Order::where('user_id', auth()->user()->id)->get();
        return Inertia::render('Orders/Index', [
            'orders' => $orders,
        ]);
    }

    public function store(Request $request)
    {
        // validate the request with all tables from the order migration
        $request->validate([
            'user_id' => 'required',
            'shipping_address_id' => 'required',
            'order_date' => 'required',
            'order_status' => 'required',
            'preferred_delivery_date' => 'required',
            'payment_method' => 'required',
            'skus' => 'array,required',
        ]);

        $order = Order::create($request->all());

        foreach ($request->skus as $sku) {
            $order->skus()->attach($sku->id, [
                'quantity' => $sku['quantity'],
                'price' => $sku['price'],
            ]);
        }

        return redirect()->route('orders.show', $order->id);
    }

    public function show(Int $id)
    {
        $order = Order::find($id);
        return Inertia::render('Orders/Detail', [
            'order' => $order,
        ]);
    }

    public function edit(Order $order)
    {
        Inertia::render('Orders/Edit', [
            'order' => $order,
        ]);
    }

    public function cancelOrder(Int $id)
    {
        $order = Order::find($id);
        $order->order_status = 'cancelled';
        $order->save();
        return redirect()->route('orders.show', $order->id);
    }
}