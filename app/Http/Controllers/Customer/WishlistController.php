<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WishlistController extends Controller
{
    public function index()
    {
        return Inertia::render('Customer/Checkout/Wishlist', [
            'cart' => $this->getlistItemsPerUser(),
        ]);
    }

    public function store(Request $request)
    {
        $cart = Wishlist::where('user_id', auth()->user()->id)
            ->where('sku_id', $request->sku_id)
            ->first();

        if ($cart) {
            $cart->amount = $cart->amount + $request->amount;
            $cart->save();

            return redirect()->route('customer.wishlist.index')->with('success', 'Product added to wishlist');
        }

        Wishlist::create([
            'user_id' => auth()->user()->id,
            'sku_id' => $request->sku_id,
        ]);

        return redirect()->route('customer.wishlist.index')->with('success', 'Product added to wishlist');
    }

    public function getlistItemsPerUser()
    {
        return Wishlist::where('user_id', auth()->user()->id)
            ->with('sku')
            ->with('sku.product')
            ->with('sku.productImages')
            ->with('sku.product.brand')
            ->with('sku.attributeValues')
            ->with('sku.promos')
            ->get();
    }

    public function show()
    {
        return $this->getlistItemsPerUser();
    }

    public function destroy(Int $id)
    {
        Wishlist::destroy($id);
        return redirect()->route('customer.wishlist.index')->with('success', 'Product removed from wishlist');
    }
}