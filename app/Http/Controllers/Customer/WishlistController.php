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
            'wishlist' => $this->getListItemsPerUser(),
        ]);
    }

    public function store(Request $request)
    {
        Wishlist::create([
            'user_id' => auth()->user()->id,
            'sku_id' => $request->sku_id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Product added to wishlist',
            'count' => $this->getAmountOfItemsInWishlist(),
        ]);
    }

    public function getListItemsPerUser()
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

    public function getAmountOfItemsInWishlist()
    {
        if (!auth()->user()) {
            return response()->json([
                'status' => 'success',
                'count' => 0,
            ]);
        }

        $count = Wishlist::where('user_id', auth()->user()->id)->count();
        return response()->json([
            'status' => 'success',
            'count' => $count,
        ]);

    }

    public function show()
    {
        return $this->getlistItemsPerUser();
    }

    public function destroy(Int $id)
    {
        Wishlist::where("sku_id", $id)->where("user_id", auth()->user()->id)->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Product removed from wishlist',
        ]);
    }
}
