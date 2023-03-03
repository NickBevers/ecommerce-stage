<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Sku;
use App\Models\SubCategory;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductVariationsController extends Controller
{
    public function index(Request $request)
    {
        $title = $request->input('title');
        $audience = $request->input('audience');
        $category = $request->input('category');
        $is_promotion = $request->input('is_promotion');
        $color = $request->input('color');
        $size = $request->input('size');
        $priceMin = $request->input('priceMin');
        $priceMax = $request->input('priceMax');
        $brand = $request->input('brand');
        $material = $request->input('material');

        $products = Sku::where('in_stock', true)
            ->when($title, function ($query, $title) {
                return $query->where('title', 'like', '%' . $title . '%');
            })
            ->when($audience, function ($query, $audience) {
                return $query->whereHas('product', function ($query) use ($audience) {
                    $query->where('audience', $audience);
                })->with('product');
            })
            ->when($category, function ($query, $category) {
                $categoryId = Category::where('label', $category)->first()->id;
                $subCategories = SubCategory::where('category_id', $categoryId)->get();
                // get the product_variations where the products that have the subcategories as their category_id
                $query->whereHas('product', function ($query) use ($subCategories) {
                    $query->whereIn('category_id', $subCategories->pluck('id'));
                })->with('product') ;
            })
            ->when($is_promotion, function ($query, $is_promotion) {
                return $query->whereHas('product', function ($query) use ($is_promotion) {
                    $query->where('is_promotion', $is_promotion);
                })->with('product');
            })
            ->when($color, function ($query, $color) {
                $colorId = Variation::where('value', $color)->first()->id;
                return $query->with('product')->where('color_variation_id', $colorId);
            })
            ->when($size, function ($query, $size) {
                return $query->whereJsonContains('sizes', $size);
            })
            ->when($priceMin, function ($query, $priceMin) {
                return $query->where('price', '>=', $priceMin);
            })
            ->when($priceMax, function ($query, $priceMax) {
                return $query->where('price', '<=', $priceMax);
            })
            ->when($brand, function ($query, $brand) {
                $brands = Brand::where('name', 'like', '%' . $brand . '%')->get()->pluck('id')->toArray();
                return $query->whereHas('product', function ($query) use ($brands) {
                    $query->whereIn('brand_id', $brands);
                })->with('product');
            })
            ->when($material, function ($query, $material) {
                return $query->whereHas('product', function ($query) use ($material) {
                    $query->where('material_id', $material);
                })->with('product');
            })
            ->with('product')
            ->get();

        return $products;

//        return Inertia::render('products/index', [
//            'products' => $products
//        ]);
    }


    public function showShoes(Request $request)
    {
        $request->merge(['category' => "shoes"]);
        return $this->index($request);
    }

    public function showClothing(Request $request)
    {
        $request->merge(['category' => "clothing"]);
        return $this->index($request);
    }

    public function showAccessories(Request $request)
    {
        $request->merge(['category' => "accessories"]);
        return $this->index($request);
    }

    public function showPromos(Request $request)
    {
        $request->merge(['is_promotion' => true]);
        return $this->index($request);
    }

    public function testFunc(Request $request)
    {
        $brand = $request->input('brand');
        $brands = Brand::where('name', 'like', '%' . $brand . '%')->get()->pluck('id')->toArray();
        Debugbar::debug($brands);

//        return Inertia::render('products/index', [
//            'products' => $brands
//        ]);
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show(Sku $productVariation)
    {
    }

    public function edit(Sku $productVariation)
    {
    }

    public function update(Request $request, Sku $productVariation)
    {
    }

    public function destroy(Sku $productVariation)
    {
    }
}