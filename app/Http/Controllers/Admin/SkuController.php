<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttributeType;
use App\Models\AttributeValue;
use App\Models\Sku;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SkuController extends Controller
{
    public function index()
    {
        // Retrieve all the SKUs with their variations
//        $skus = Sku::find(1)
//            ->with('variations')
//            ->with('product')
//            ->with('product.subCategory');

        $skus = Sku::where('id', 1)
            ->with('variations')
            ->with('product')
            ->with('product.subCategory')
            ->get();

        foreach ($skus as $sku) {
            $attributeValues = [];
            $colorSizes = [];
            foreach ($sku->variations as $variation) {
                // If the variation is an colorSize, add the color and size to an array
                if ($variation->variation_type === 'App\Models\ColorSize'){
                    $color = $variation->variation->color->name;
                    $size = $variation->variation->size->name;

//                    ray($color);

                    if (!in_array($color, $colorSizes)) {
                        $colorSizes[$color] = [$size];
                    } else {
                        ray(false);
                    }
                }

                if ($variation->variation_type === 'App\Models\AttributeValue') {
                    $attributeValue = AttributeValue::where('name', $variation->variation->name)->first();
                    $attributeType = AttributeType::where('id', $attributeValue->attribute_type_id)->first();

                    if (!in_array($attributeType->name, $attributeValues)) {
                        $attributeValues[$attributeType->name] = [$variation->variation->name];
                    }

                    if (!in_array($variation->variation->name, $attributeValues[$attributeType->name])) {
                        $attributeValues[$attributeType->name][] = $variation->variation->name;
                    }
                }

            }

            $sku->attributeValues = $attributeValues;
            $sku->colorSizes = $colorSizes;
            $sku->variations = [];
        }

        return $skus;

//        return Inertia::render('Admin/Products/Index', [
//            'skus' => Sku::with(['variations' => function ($query) { $query->with('variation'); }])
//                ->with('product')
//                ->orderBy('sku')
//                ->paginate(10),
//            'attributeValues' => AttributeValue::all(),
//            'minPrice' => Sku::min('price'),
//            'maxPrice' => Sku::max('price'),
//        ]);
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
//        $sku = Sku::find(1);
//        $res = $sku->attributeValues()->wherePivot('attribute_value_id', 3)->get();
//        $res = $sku->morphedByMany(ColorSize::class, 'variation', 'sku_variations')->get();
//        ray($res);

        return $this->sortClothing(['6XL', 'XXL', '3XL']);
    }

    public function store(Request $request)
    {
    }

    public function sortClothing(Array $data): array
    {
        $sizes = [ 'One Size', 'XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL', '3XL', '4XL', '5XL', '6XL', '7XL', '8XL', '23', '24', '25', '26', '27', '28', '29', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45', '46', '47', '48', '49', '50', '52', '54', '56', '58', '60', '62', '64', '66', '68', '70', '90', '94', '98', '102','106', '110',];
        $res = array_intersect($sizes, $data);
        return array_values($res);
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