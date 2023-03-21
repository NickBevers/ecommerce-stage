<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Controller;
use App\Models\AttributeValue;
use App\Models\Sku;
use App\Models\SubCategory;
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

    public function filter(Request $request)
    {
        $category = $request->has('category')? $request->input('category') : false;
        $subCategory = $request->has('subCategory')? $request->input('subCategory') : false;
        $promo = $request->has('promo')? $request->input('promo') : false;
        $attributes = $request->has('attributes')? $request->input('attributes') : false;
        $price = $request->has('price')? $request->input('price') : false;
        $brand = $request->has('brand')? $request->input('brand') : false;
        $sort = $request->has('sort')? $request->input('sort') : 'created_at';
        $order = $request->has('order')? $request->input('order') : 'asc';

        $skus = Sku::with('attributeValues')
            ->with('product')
            ->with('promos')
            ->with('product.brand')
            ->with('productImages')
            ->with('product.subCategory')
            ->when($category, function ($query) use ($category){
                $query->whereHas('product.subCategory.category', function ($query) use ($category) {
                    $query->where('name', $category);
                });
            })
            ->when($subCategory, function ($query) use ($subCategory){
                $query->whereHas('product.subCategory', function ($query) use ($subCategory) {
                    $query->where('slug', $subCategory);
                });
            })
            ->when($promo, function ($query) use ($promo){
                $query->whereHas('promo', function ($query) use ($promo) {
                    $query->where('start_date', '<=', now())
                        ->where('end_date', '>=', now());
                });
            })
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
            ->when($sort && $order, function ($query) use ($sort, $order){
                $query->orderBy($sort, $order);
            })
            ->paginate(48);

        // return the skus and min and max price
//        dd(app(SubCategoryController::class)->getSubCategoryBySlug($subCategory));
        return [
            'skus' => $skus,
            'subCategory' => app(SubCategoryController::class)->getSubCategoryBySlug($subCategory),
            'minPrice' => $skus->min('price'),
            'maxPrice' => $skus->max('price'),
        ];
    }

    public function showBySubCategory(String $subCategory)
    {
        $data = $this->filter(new Request(['subCategory' => $subCategory]));
        return Inertia::render('Customer/Products/Index', $data);
    }

    public function showShoes(Request $request)
    {
        $request->merge(['category' => "Shoes"]);
        return $this->filter($request);
    }

    public function showClothing(Request $request)
    {
        $request->merge(['category' => "Clothing"]);
        return $this->filter($request);
    }

    public function showAccessories(Request $request)
    {
        $request->merge(['category' => "Accessories"]);
        return $this->filter($request);
    }

    public function showPromos(Request $request)
    {
        $request->merge(['promo' => true]);
        return Inertia::render('Customer/Products/Index', $this->filter($request));
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

    public function show(String $sku)
    {
        $sku = Sku::where('sku', $sku)
            ->with('attributeValues')
            ->with('productImages')
            ->with('product')
            ->with('product.brand')
            ->with('product.subCategory')
            ->first();

        ray($sku);

        $attributeValues = $sku->attributeValues;
        $material = $attributeValues->where('attribute_type_id', 3)->first();
        $sizes = [];
        $colors = [];
        foreach ($attributeValues as $attributeValue) {
            if ($attributeValue->attribute_type_id == 1) {
                $sizes[] = $attributeValue->name;
            } else if ($attributeValue->attribute_type_id == 2) {
                $colors[] = [
                    "name" => $attributeValue->name, 
                    "hex" => $attributeValue->color_value];
            }
        }

        $variations = Sku::where('product_id', $sku->product_id)
            ->whereNotIn('sku', [$sku->sku])
            ->get();

        return Inertia::render('Customer/Product/Index', [
            'sku' => $sku,
            'variations' => $variations,
            'sizes' => $sizes,
            'colors' => $colors,
            'material' => $material?->name,
        ]);
    }
}