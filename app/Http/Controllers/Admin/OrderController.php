<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Address;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::orderBy('created_at', 'desc')->get();

        $ordersWithAddresses = [];

        foreach ($orders as $order) {
            $ordersWithAddresses[] = [
                'order' => $order,
                'shipping_address' => Address::where('id', $order->shipping_address_id)->first(),
                'billing_address' => Address::where('id', $order->billing_address_id)->first(),
            ];
        }
        
        return Inertia::render('Admin/Orders/Index', [
            'orders' => $ordersWithAddresses,
        ]);
        
    }

    public function updateOrderLine(Request $request, Order $order)
    {
        $order->skus()->updateExistingPivot($request->sku_id, [
            'amount' => $request->amount,
        ]);
        return response()->json([
            'message' => 'Order line updated',
        ]);
    }
    
    public function deleteOrderLine(Request $request, Order $order)
    {
        $order->skus()->detach($request->sku_id);
        return response()->json([
            'message' => 'Order line deleted',
        ]);
    }

    public function show(Order $order)
    {
//        return response()->json($order->withRelations()->get());
            return Inertia::render('Admin/Orders/Detail', [
                'order' => Order::where('id', $order->id)->withRelations()->get()->first(),
                'shipping_address' => Address::where('id', $order->shipping_address_id)->first(),
                'billing_address' => Address::where('id', $order->billing_address_id)->first(),
            ]);
    }

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

    public function updateTracking(Request $request, Order $order)
    {
        $request->validate([
            'tracking_number' => 'required',
            'tracking_url' => 'required',
        ]);

        $order->update([
            'tracking_number' => $request->tracking_number,
            'tracking_url' => $request->tracking_url,
        ]);

        return redirect()->route('orders.show', $order->id);
    }

    public function updateShippedAt(Request $request, Order $order)
    {
        $request->validate([
            'shipped_at' => 'required',
        ]);

        $order->update([
            'shipped_at' => $request->shipped_at,
        ]);

        return redirect()->route('orders.show', $order->id);
    }
}