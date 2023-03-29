<?php

namespace App\Services;

use App\Models\AttributeValue;
use App\Models\Sku;
use Illuminate\Http\Request;

class SkuService
{
    public function filter(Request $request)
    {
        $category = $request->input('category', false);
        $subCategory = $request->input('subCategory', false);
        $promo = $request->input('promo', false);
        $attributes = $request->input('attributes', false);
        $price = $request->input('price', false);
        $brand = $request->input('brand', false);
        $sort = $request->input('sort', 'created_at');
        $order = $request->input('order', 'asc');

        return Sku::withAllRelations()
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
                $query->whereHas('promos', function ($query) use ($promo) {
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
    }

    public function attachAttributes($sku, $color, $material, $sizes)
    {
        $sku->attributeValues()->attach($color);
        $sku->attributeValues()->attach($material);

        foreach ($sizes as $size) {
            $size = AttributeValue::where('name', $size)->first();
            $sku->attributeValues()->attach($size);
        }
    }
}