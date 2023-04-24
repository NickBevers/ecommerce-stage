<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\UserPaymentMethod;
use App\Models\PaymentType;
use App\Models\Sku;
use App\Models\Wishlist;
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

    public function getCheckoutData()
    {
        return Inertia::render('Customer/Checkout/Index', [
            'cart' => $this->getProductsPerUser(),
            'addresses' => auth()->user()->addresses,
            'paymentTypes' => PaymentType::all(),
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
                'count' => $this->getAmountOfItemsInCart(),
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
            'count' => $this->getAmountOfItemsInCart(),
        ]);
    }

    public function getProductsPerUser()
    {
        if (!auth()->user()) {
            return [];
        }

        return Cart::where('user_id', auth()->user()->id)
            ->withSku()
            ->get();
    }

    public function getAmountOfItemsInCart()
    {
        if (!auth()->user()) {
            return response()->json([
                'status' => 'success',
                'count' => 0,
            ]);
        }

        $count = Cart::where('user_id', auth()->user()->id)->sum('amount');
        return response()->json([
            'status' => 'success',
            'count' => $count,
        ]);
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

        return response()->json([
            'status' => 'success',
            'message' => 'Product updated in cart',
        ]);
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