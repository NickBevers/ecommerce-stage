<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Product\ProductController;
use App\Models\AttributeValue;
use App\Models\Sku;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SkuController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Products/Index', [
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
        $attributeTypes = app(AttributeTypesController::class)->getAllTypes();
        foreach ($attributeTypes as $attributeType) {
            $attributeType->attributeValues = app(AttributeValueController::class)->getValuesByType($attributeType->id);
        }

        $categories = app(CategoryController::class)->getAllCategories();
        foreach ($categories as $category) {
            $category->subCategories = app(SubCategoryController::class)->getSubCategoriesById($category->id);
        }
       return Inertia::render('Admin/Products/Create', [
           'brands' => app(BrandController::class)->getAllBrands(),
           'categories' => $categories,
           'attributeTypes' => $attributeTypes,
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