<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Address;
use App\Models\OrderLine;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::orderBy('created_at', 'desc')
            ->with('shippingAddress', 'billingAddress')
            ->withRelations()
            ->paginate(10);
        
        return Inertia::render('Admin/Orders/Index', [
            'orders' => $orders,
        ]);
        
    }

    public function updateOrderLine(Order $order, Request $request)
    {
        $order->skus()->updateExistingPivot($request->sku_id, [
            'amount' => $request->amount,
        ]);
        return response()->json([
            'message' => 'Order line updated',
        ]);
    }
    
    public function deleteOrderLine(Order $order, Request $request)
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

        return redirect()->route('admin.orders.index');
    }

    function getSalesToday()
    {
        $salesToday = Order::where('created_at', '>=', now()->startOfDay())
            ->where('created_at', '<=', now()->endOfDay())
            ->sum('total_price');

        $salesToday = floatval(number_format((float)$salesToday, 2, '.', ''));

//        Carbon::today()->toDateString()
        $salesYesterday = Order::where('created_at', '>=', Carbon::yesterday()->setTime(00, 00, 00)->toDateTimeString())
            ->where('created_at', '<=', Carbon::yesterday()->setTime(23, 59, 59)->toDateTimeString())
            ->sum('total_price');

        return response()->json([
            'amount' => $salesToday,
            'orderAmount' => Order::where('created_at', '>=', now()->startOfDay())
                ->where('created_at', '<=', now()->endOfDay())
                ->count(),
            'skusSold' =>  OrderLine::whereIn('order_id', Order::where('created_at', '>=', now()->startOfDay())
                ->where('created_at', '<=', now()->endOfDay())->pluck('id'))->get()->sum('amount'),
            'skus' => OrderLine::whereIn('order_id', Order::where('created_at', '>=', now()->startOfDay())
                ->where('created_at', '<=', now()->endOfDay())->pluck('id'))->withAllRelations()->get(),
            'amountYesterday' => $salesYesterday,
            'orderAmountYesterday' => Order::where('created_at', '>=', Carbon::yesterday()->setTime(00, 00, 00)->toDateTimeString())
                ->where('created_at', '<=', Carbon::yesterday()->setTime(23, 59, 59)->toDateTimeString())
                ->count(),
            'skusSoldYesterday' =>  OrderLine::whereIn('order_id', Order::where('created_at', '>', Carbon::yesterday()->setTime(00, 00, 00)->toDateTimeString())
                ->where('created_at', '>', Carbon::yesterday()->setTime(23, 59, 59)->toDateTimeString())
                ->pluck('id'))->get()->sum('amount'),
        ]);
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

        $this->index();
    }
}