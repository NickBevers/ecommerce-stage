<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\AttributeType;
use App\Models\Sku;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

//TODO wishlist fix

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
        // get all the wishlist items per user and get per sku every relation
        $wishlist = Wishlist::where('user_id', auth()->user()->id)
            ->withSku()
            ->get();

        foreach ($wishlist as $item) {
            $item->sku = Sku::where('id', $item->sku->id)->withAllRelations()->first();
            $sku = Sku::where('sku', $item->sku->sku)->withAllRelations()->first();

            $activeSkuAttributes = $sku->attributeValues->where('attribute_type_id', '!=',AttributeType::where('name', 'size')->first()->id)->pluck('id')->toArray();
            ray($activeSkuAttributes);

            $sizeVariations = Sku::where('product_id', $sku->product_id)
                ->where('is_active', true)
                ->whereHas('attributeValues', function ($query) use ($activeSkuAttributes) {
                    $query->whereIn('attribute_value_id', $activeSkuAttributes);
                })
                ->with('attributeValues', function ($query) {
                    $query->where('attribute_type_id', '!=', AttributeType::where('name', 'size')->first()->id);
                })
                ->with('productImages', function ($query) {
                    $query->where('image_type', 'thumbnails');
                })
                ->get();

            foreach ($sizeVariations as $sizeVariation) {
                $attributeArray = $sizeVariation->attributeValues->pluck('id')->toArray();
                if (array_intersect($activeSkuAttributes, $attributeArray) != $activeSkuAttributes) {
                    $sizeVariations = $sizeVariations->where('id', '!=', $sizeVariation->id);
                } else {
                    $sizeVariation->size = Sku::where('id', $sizeVariation->id)->with('attributeValues', function ($query) {
                        $query->where('attribute_type_id', AttributeType::where('name', 'size')->first()->id);
                    })->first()->attributeValues->first()->name;
                }
            }

            $item->sku->sizeVariations = array_values($sizeVariations->toArray());
        }

        return $wishlist;
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
        return response()->json([
            'status' => 'success',
            'message' => 'Product removed from wishlist',
        ]);
    }
}
