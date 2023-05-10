<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderValidationRequest;
use App\Mail\OrderPlaced;
use App\Mail\OrderShipped;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Sku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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

    public function store(OrderValidationRequest $request)
    {
        $shipping_address = Address::where('id', $request->shipping_address_id)->first();
        ray("$shipping_address->address_line_1, $shipping_address->postal_code $shipping_address->city");
        $request->merge([
            'delivery_address' => "$shipping_address->address_line1 $shipping_address->address_line2, $shipping_address->postal_code $shipping_address->city",
        ]);

        $order = Order::create($request->all());

        foreach ($request->skus as $sku) {
            if ($sku['amount'] > $sku['sku']['amount']) {
                return redirect()->back()->with('error', 'There is not enough stock for this product' . $sku['sku']['product']['title']);
            }

            $product_name = $sku['sku']['product']['title'];
            $order->skus()->attach($sku['sku_id'], [
                'amount' => $sku['amount'],
                'product_name' => $product_name,
                'price' => $sku['sku']['price_incl_vat'],
            ]);

            Sku::where('id', $sku['sku_id'])->decrement('amount', $sku['amount']);
        }

        Cart::where('user_id', auth()->user()->id)->delete();

        Mail::to($order->user->email)->send(new OrderPlaced($order));

        return Inertia::render('Customer/Checkout/Detail', [
            'order' => $order,
            'shipping_address' => Address::where('id', $order->shipping_address_id)->first(),
            'billing_address' => Address::where('id', $order->billing_address_id)->first(),
            'skus' => $order->skus->load('productImages', 'product'),
        ]);
    }

    function mailTest()
    {
        $order = Order::find(2);
        Mail::to('john.doe@gmail.com')->send(new OrderShipped($order));
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
