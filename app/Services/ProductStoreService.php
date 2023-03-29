<?php

namespace App\Services;

use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Product\ProductImageController;
use App\Models\Product;


class ProductStoreService
{
    public function store($request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'brand_id' => 'required',
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'price' => 'required',
            'quantity' => 'required',
            'sku' => 'required',
            'images' => 'required',
        ]);


        $product = Product::create($request->all());
        $product->save();

        return $product;
    }
}