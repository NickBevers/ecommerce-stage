<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\AttributeType;
use App\Models\AttributeValue;
use App\Models\Sku;
use App\Services\GetAttributeValuesService;
use App\Services\SkuService;
use App\Services\SubCategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class SkuController extends Controller
{
    private SubCategoryService $subCategoryService;
    private SkuService $skuService;
    private GetAttributeValuesService $attributeValueService;

    public function __construct()
    {
        $this->subCategoryService = new SubCategoryService();
        $this->skuService = new SkuService();
        $this->attributeValueService = new GetAttributeValuesService();
    }

    public function index()
    {
        return Inertia::render('Products', [
            'skus' => Sku::where('is_active', true)
                ->withAllRelations()
                ->orderBy('sku')
                ->paginate(48),
            'attributeValues' => AttributeValue::all(),
            'minPrice' => Sku::min('price_incl_vat'),
            'maxPrice' => Sku::max('price_incl_vat'),
        ]);
    }

    public function filter(Request $request)
    {
        $filter = $this->skuService->filter($request);
        $colors = $this->skuService->getUniqueAttributeValues($filter['skus']->get(), "color");
        $sizes = $this->skuService->getUniqueAttributeValues($filter['skus']->get(), "size");
        $materials = $this->skuService->getUniqueAttributeValues($filter['skus']->get(), "material");
        $brands = $this->skuService->getUniqueBrands($filter['skus']->get());

        $filter['skus'] = $filter['skus']->paginate(48);

        return [
            'skus' => $filter['skus'],
            'attributeTypes' => $filter['attributeTypes'],
            'subCategory' => $this->subCategoryService->getSubCategoryBySlug($request->input('subCategory', '')),
            'minPrice' => $filter['skus']->min('price_incl_vat'),
            'maxPrice' => $filter['skus']->max('price_incl_vat'),
            'colors' => $colors,
            'sizes' => $sizes,
            'materials' => $materials,
            'brands' => $brands,
        ];
    }

    public function showBySubCategory(String $subCategory)
    {
        $data = $this->filter(new Request(['subCategory' => $subCategory]));
        return Inertia::render('Customer/Products/Index', $data);
    }

    public function showByCategory(String $category)
    {
        return $this->filter(new Request(['category' => $category]));
    }

    public function showPromos(Request $request)
    {
        $request->merge(['promo' => true]);
        return Inertia::render('Customer/Products/Index', $this->filter($request));
    }

    public function sortSizes(Array $data): array
    {
//        $sizes = [ 'One Size', 'XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL', '3XL', '4XL', '5XL', '6XL', '7XL', '8XL', '23', '24', '25', '26', '27', '28', '29', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45', '46', '47', '48', '49', '50', '52', '54', '56', '58', '60', '62', '64', '66', '68', '70', '90', '94', '98', '102','106', '110',];
        $sizes = $this->attributeValueService->getValuesByType("size")->pluck('name')->toArray();
        $res = array_intersect($sizes, $data);
        return array_values($res);
    }

    public function show(Sku $sku)
    {
        $attributes = $sku->attributeValues->toArray();
        $sku = Sku::where('sku', $sku->sku)->withAllRelations()->first();
//        $material = $attributeValues->where('attribute_type_id', AttributeType::where('name', 'material')->first()->id)->first();
//        $sizes = [];
//        $colors = [];
//        foreach ($attributeValues as $attributeValue) {
//            if ($attributeValue->attribute_type_id == AttributeType::where('name', 'size')->first()->id) {
//                $sizes[] = $attributeValue->name;
//            }
//            if ($attributeValue->attribute_type_id == AttributeType::where('name', 'color')->first()->id) {
//                $colors[] = [
//                    "name" => $attributeValue->name,
//                    "hex" => $attributeValue->color_value];
//            }
//        }

        $temp = $sku->attributeValues->where('attribute_type_id', '!=',AttributeType::where('name', 'size')->first()->id)->pluck('id')->toArray();
        ray($temp);

        $sizeVariations = Sku::where('product_id', $sku->product_id)
            ->where('is_active', true)
            ->whereHas('attributeValues', function ($query) use ($temp) {
                $query->whereIn('attribute_value_id', $temp);
            })
            ->with('attributeValues', function ($query) {
                $query->where('attribute_type_id', '!=', AttributeType::where('name', 'size')->first()->id);
            })
            ->with('productImages', function ($query) {
                $query->where('image_type', 'thumbnails');
            })
            ->get();

        ray($sizeVariations);

        foreach ($sizeVariations as $sizeVariation) {
            $attributeArray = $sizeVariation->attributeValues->pluck('id')->toArray();
            if (array_intersect($temp, $attributeArray) != $temp) {
                $sizeVariations = $sizeVariations->where('id', '!=', $sizeVariation->id);
            } else {
                $sizeVariation->size = Sku::where('id', $sizeVariation->id)->with('attributeValues', function ($query) {
                    $query->where('attribute_type_id', AttributeType::where('name', 'size')->first()->id);
                })->first()->attributeValues->first()->name;
            }
        }

        $variations = Sku::where('product_id', $sku->product_id)
            ->whereNotIn('sku', [$sku->sku])
            ->where('is_active', true)
            ->whereNotIn('id', $sizeVariations->pluck('id')->toArray())
            ->with('attributeValues')
            ->with('productImages', function ($query) {
                $query->where('image_type', 'thumbnails');
            })
            ->get();

        $sizeVariations = array_values($sizeVariations->toArray());


        $reviews = $sku->reviews;
        foreach ($reviews as $review) {
            $review->upvotes = $review->upvotes()->count();
            $review->userLikes = $review->upvotes()->where('user_id', Auth::id())->exists();
        }

        $hasBought = false;

        if (Auth::check()) {
            $hasBought = $sku->orders()->where('user_id', Auth::id())->exists();
        }


        return Inertia::render('Customer/Product/Index', [
            'sku' => $sku,
            'variations' => $variations,
//            'sizes' => $sizes,
//            'colors' => $colors,
//            'material' => $material?->name,
            'userHasBought' => $hasBought,
            'sizeVariations' => $sizeVariations,
        ]);
    }
}