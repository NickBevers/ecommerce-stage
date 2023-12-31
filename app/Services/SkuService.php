<?php

namespace App\Services;

use App\Models\AttributeType;
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
        $brands = $request->input('brand', false);
        $sort = $request->input('sort', 'created_at');
        $order = $request->input('order', 'desc');

        // return the skus and the attributeTypes
        return [
            "skus" => Sku::where('is_active', true)->withAllRelations()
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
                    for ($i = 0; $i < count($attributes); $i++) {
                        $query->whereHas('attributeValues.attributeType', function ($query) use ($attributes, $i) {
                            $query->where('name', array_keys($attributes)[$i]);
                        })
                            ->whereHas('attributeValues', function ($query) use ($attributes, $i) {
                                $query->whereIn('name', $attributes[array_keys($attributes)[$i]]);
                            });
                    }
                })
                ->when($price, function ($query) use ($price){
                    $query->where('price', '>=', $price[0])
                        ->where('price', '<=', $price[1]);
                })
                ->when($brands, function ($query) use ($brands){
                    $query->whereHas('product.brand', function ($query) use ($brands) {
                        $query->whereIn('slug', $brands);
                    });
                })
                ->when($sort && $order, function ($query) use ($sort, $order){
                    if ($sort === 'title') {
                        $query->whereHas('product', function ($query) use ($order) {
                            $query->orderBy('title', $order);
                        });
                    } else if ($sort === 'rating') {
                        $query->whereHas('reviews', function ($query) use ($order) {
                            $query->orderBy('score', $order);
                        });
                    } else {
                        $query->orderBy($sort, $order);
                    }
                }),
            "attributeTypes" => AttributeType::get('name'),
        ];
    }


    public function getUniqueAttributeValues($skus, $attributeType): array
    {
        $tempArr = [];
        foreach ($skus as $sku => $value) {
            foreach ($value->attributeValues as $attributeValue) {
                if ($attributeValue->attributeType->name === $attributeType) {
                    $tempArr[] = Array('id' => $attributeValue->id, 'name' => $attributeValue->name, 'color' => $attributeValue->color_value);
                }
            }
        }

        return collect($tempArr)->sortBy('id')->unique('id')->values()->all();
    }

    public function getUniqueBrands($skus): array
    {
        $tempArr = [];
        foreach ($skus as $sku => $value) {
            $tempArr[] = Array('id' => $value->product->brand->id, 'name' => $value->product->brand->name, 'slug' => $value->product->brand->slug);
        }

        return collect($tempArr)->sortBy('id')->unique('id')->values()->all();
    }
}