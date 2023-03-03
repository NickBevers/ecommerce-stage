<?php

namespace App\Http\Controllers;

use App\Models\AttributeValue;
use App\Models\Sku;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SkuController extends Controller
{
    public function index()
    {
        return Inertia::render('Test/Index', [
            'skus' => Sku::with('attributeValues')
                ->with('product')
                ->orderBy('sku')
                ->paginate(10),
            'attributeValues' => AttributeValue::all(),
        ]);
        // get all sku's with their attribute values sorted by sku

    }

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
    }

    public function store(Request $request)
    {
    }

    public function show(Sku $sku)
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