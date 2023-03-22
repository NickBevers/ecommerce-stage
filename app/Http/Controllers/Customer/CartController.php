<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    public function index()
    {

    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function getProductsPerUser()
    {
        return Cart::where('user_id', auth()->user()->id)
            ->with('sku')
            ->with('sku.product')
            ->with('sku.productImages')
            ->with('sku.product.brand')
            ->with('sku.attributeValues')
            ->with('sku.promos')
            ->get();
    }

    public function show(Cart $cart)
    {
        return Inertia::render('Customer/Cart/Index', [
            'skus' => $cart->skus,
        ]);
    }

    public function edit(Cart $cart)
    {
    }

    public function update(Request $request, Cart $cart)
    {
    }

    public function destroy(Cart $cart)
    {
    }
}