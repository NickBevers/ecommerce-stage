<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttributeValue;
use App\Models\Sku;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SkuController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Products', [
            'skus' => Sku::with('attributeValues')
                ->with('product')
                ->orderBy('sku')
                ->paginate(10),
            'attributeValues' => AttributeValue::all(),
            'minPrice' => Sku::min('price'),
            'maxPrice' => Sku::max('price'),
        ]);
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('searchTerm');
        return Sku::with('attributeValues')
            ->with('product')
            -> whereHas('product', function ($query) use ($searchTerm) {
                $query->where('title', 'like', '%' . $searchTerm . '%');
            })
            ->orderBy('sku')
            ->paginate(10);
    }

    public function create()
    {
        return Inertia::render('Admin/Products/Create', [
            'sizes' => app(AttributeValueController::class)->getSizes(),
            'colors' => app(AttributeValueController::class)->getColors(),
            'materials' => app(AttributeValueController::class)->getMaterials(),
            'brands' => app(BrandController::class)->getAllBrands(),
            'categories' => app(CategoryController::class)->getAllCategories(),
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