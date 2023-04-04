<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\AttributeType;
use App\Models\AttributeValue;
use App\Models\Sku;
use App\Services\SkuService;
use App\Services\SubCategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class SkuController extends Controller
{
    private SubCategoryService $subCategoryService;
    private SkuService $skuService;

    public function __construct()
    {
        $this->subCategoryService = new SubCategoryService();
        $this->skuService = new SkuService();
    }

    public function index()
    {
        return Inertia::render('Products', [
            'skus' => Sku::with('attributeValues')
                ->with('product')
                ->orderBy('sku')
                ->paginate(48),
            'attributeValues' => AttributeValue::all(),
            'minPrice' => Sku::min('price_incl_vat'),
            'maxPrice' => Sku::max('price_incl_vat'),
        ]);
    }

    public function filter(Request $request)
    {
        $skus = $this->skuService->filter($request);
        return [
            'skus' => $skus,
            'subCategory' => $this->subCategoryService->getSubCategoryBySlug($request->input('subCategory', '')),
            'minPrice' => $skus->min('price_incl_vat'),
            'maxPrice' => $skus->max('price_incl_vat'),
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

    public function show(Sku $sku)
    {
        $tempSku = Sku::where('sku', $sku->sku)->withAllRelations()->first();
        $attributeValues = $tempSku->attributeValues;
        $material = $attributeValues->where('attribute_type_id', AttributeType::where('name', 'material')->first()->id)->first();
        $sizes = [];
        $colors = [];
        foreach ($attributeValues as $attributeValue) {
            if ($attributeValue->attribute_type_id == AttributeType::where('name', 'size')->first()->id) {
                $sizes[] = $attributeValue->name;
            }
            if ($attributeValue->attribute_type_id == AttributeType::where('name', 'color')->first()->id) {
                $colors[] = [
                    "name" => $attributeValue->name, 
                    "hex" => $attributeValue->color_value];
            }
        }

        $variations = Sku::where('product_id', $tempSku->product_id)
            ->whereNotIn('sku', [$tempSku->sku])
            ->with('productImages', function ($query) {
                $query->where('image_type', 'thumbnail');
            })
            ->get();

        $reviews = $tempSku->reviews;
        foreach ($reviews as $review) {
            $review->upvotes = $review->upvotes()->count();
            $review->userLikes = $review->upvotes()->where('user_id', Auth::id())->exists();
        }

        return Inertia::render('Customer/Product/Index', [
            'sku' => $tempSku,
            'variations' => $variations,
            'sizes' => $sizes,
            'colors' => $colors,
            'material' => $material?->name,
        ]);
    }
}