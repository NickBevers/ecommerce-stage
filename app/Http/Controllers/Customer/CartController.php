<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Sku;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    public function index()
    {
        return Inertia::render('Customer/Checkout/ShoppingBag', [
            'cart' => $this->getProductsPerUser(),
        ]);
    }

    public function store(Request $request)
    {
        $cart = Cart::where('user_id', auth()->user()->id)
            ->where('sku_id', $request->sku_id)
            ->first();

        if ($cart) {
            $cart->amount = $cart->amount + $request->amount;
            $cart->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Product added to cart',
            ]);
        }

        Cart::create([
            'user_id' => auth()->user()->id,
            'sku_id' => $request->sku_id,
            'amount' => $request->amount,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Product added to cart',
        ]);
    }

    public function getProductsPerUser()
    {
        return Cart::where('user_id', auth()->user()->id)
            ->withSku()
            ->get();
    }

    public function show()
    {
        return $this->getProductsPerUser();
    }

    public function update(Request $request, Sku $sku)
    {
        $cart = Cart::where('user_id', auth()->user()->id)
            ->where('sku_id', $sku->id)
            ->first();
        $cart->amount = $request->amount;
        $cart->save();

        return redirect()->route('customer.cart.index')->with('success', 'Product updated in cart');
    }

    public function destroy(Sku $sku)
    {
        Cart::where("sku_id", $sku->id)->where("user_id", auth()->user()->id)->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Product removed from wishlist',
        ]);
    }
}