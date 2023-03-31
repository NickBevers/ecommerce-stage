<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function getOrdersByUser()
    {
        $orders = Order::where('user_id', auth()->user()->id)->get();
        return Inertia::render('Orders/Index', [
            'orders' => $orders,
        ]);
    }

    public function store(Request $request)
    {
        $order = Order::create($request->all());

        foreach ($request->skus as $sku) {
            $order->skus()->attach($sku['id'], [
                'amount' => $sku['amount'],
                'price' => $sku['price'],
            ]);
        }

        return redirect()->route('orders.show', $order->id);
    }

    public function show(Order $order)
    {
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

    public function cancelOrder(Order $order)
    {
        $order->order_status = 'cancelled';
        $order->save();
        return redirect()->route('orders.show', $order->id);
    }
}