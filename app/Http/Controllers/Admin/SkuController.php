<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttributeValue;
use App\Models\Sku;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SkuController extends Controller
{

    public function create()
    {
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

    public function store(Request $request)
    {
    }

    public function edit(Sku $sku)
    {
    }

    public function update(Request $request, Sku $sku)
    {
    }

    public function destroy(Sku $sku)
    {
    }
}