<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\AttributeValue;
use App\Models\Sku;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SkuController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard/Products', [
            'skus' => Sku::with('attributeValues')
                ->with('product')
                ->paginate(10),
            'attributeValues' => AttributeValue::all(),
        ]);

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