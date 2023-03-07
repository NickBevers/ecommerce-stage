<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\AttributeValue;
use App\Models\Sku;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SkuController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Products', [
            'skus' => Sku::with('attributeValues')
                ->with('product')
                ->orderBy('sku')
                ->paginate(48),
            'attributeValues' => AttributeValue::all(),
            'minPrice' => Sku::min('price'),
            'maxPrice' => Sku::max('price'),
        ]);
    }

    public function filter()
    {
        $attributes = request()->has('attributes')? request()->input('attributes') : false;
        $price = request()->has('price')? request()->input('price') : false;
        $brand = request()->has('brand')? request()->input('brand') : false;

        $skus = Sku::with('attributeValues')
            ->with('product')
            ->when($attributes, function ($query) use ($attributes){
                foreach ($attributes as $attribute) {
                    $query->whereHas('attributeValues', function ($query) use ($attribute) {
                        $query->whereIn('name', $attribute);
                    });
                }
            })
            ->when($price, function ($query) use ($price){
                $query->where('price', '>=', $price[0])
                    ->where('price', '<=', $price[1]);
            })
            ->when($brand, function ($query) use ($brand){
                $query->whereHas('product.brand', function ($query) use ($brand) {
                    $query->where('slug', $brand);
                });
            })
            ->paginate(48);

        // return the skus and min and max price
        return [
            'skus' => $skus,
            'minPrice' => Sku::min('price'),
            'maxPrice' => Sku::max('price'),
        ];
    }

    public function testFunc()
    {
        // get all sku's with their attribute values where attribute value id is 3
        return Sku::with('attributeValues')
            ->whereHas('attributeValues', function ($query) {
                $query->where('attribute_type_id', 3);
            })
            ->get();


//        $sku = Sku::find(1)
//            ->attributeValues()
//            ->get();
//        return $sku;
    }

    public function show(Sku $sku)
    {
    }
}