<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Sku;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            ->withSku()
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

    public function destroy(Sku $sku)
    {
        Wishlist::where("sku_id", $sku->id)->where("user_id", auth()->user()->id)->delete();
        return redirect()->route('customer.wishlist.index')->with('success', 'Product removed from wishlist');
    }
}
