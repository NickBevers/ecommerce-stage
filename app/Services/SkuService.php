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
        $brand = $request->input('brand', false);
        $sort = $request->input('sort', 'created_at');
        $order = $request->input('order', 'asc');

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
                    $query->whereHas('attributeValues', function ($query) use ($attributes) {
                        $query->whereIn('name', $attributes);
                    });
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
                }),
            "attributeTypes" => AttributeType::get('name'),
        ];

//        return {
//            $skus = Sku::where('is_active', true)->withAllRelations()
////                ->when($category, function ($query) use ($category){
////                    $query->whereHas('product.subCategory.category', function ($query) use ($category) {
////                        $query->where('name', $category);
////                    });
////                })
////                ->when($subCategory, function ($query) use ($subCategory){
////                    $query->whereHas('product.subCategory', function ($query) use ($subCategory) {
////                        $query->where('slug', $subCategory);
////                    });
////                })
////                ->when($promo, function ($query) use ($promo){
////                    $query->whereHas('promos', function ($query) use ($promo) {
////                        $query->where('start_date', '<=', now())
////                            ->where('end_date', '>=', now());
////                    });
////                })
////                ->when($attributes, function ($query) use ($attributes){
////                    foreach ($attributes as $attribute) {
////                        $query->whereHas('attributeValues', function ($query) use ($attribute) {
////                            $query->whereIn('name', $attribute);
////                        });
////                    }
////                })
////                ->when($price, function ($query) use ($price){
////                    $query->where('price', '>=', $price[0])
////                        ->where('price', '<=', $price[1]);
////                })
////                ->when($brand, function ($query) use ($brand){
////                    $query->whereHas('product.brand', function ($query) use ($brand) {
////                        $query->where('slug', $brand);
////                    });
////                })
////                ->when($sort && $order, function ($query) use ($sort, $order){
////                    $query->orderBy($sort, $order);
////                });
//        }

    }


    public function getUniqueAttributeValues($skus, $attributeType): Array
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

    public function getUniqueBrands($skus): Array
    {
        $tempArr = [];
        foreach ($skus as $sku => $value) {
            $tempArr[] = Array('id' => $value->product->brand->id, 'name' => $value->product->brand->name, 'slug' => $value->product->brand->slug);
        }

        return collect($tempArr)->sortBy('id')->unique('id')->values()->all();
    }
}