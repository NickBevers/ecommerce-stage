<?php

namespace App\Services;

use App\Http\Requests\ProductValidationRequest;
use App\Models\Product;
class ProductService
{
    public function store(ProductValidationRequest $request): Product
    {
        $product = new Product;
        $product->title = $request->title;
        $product->slug = $request->slug;
        $product->description = $request->description;
        $product->audience = $request->audience;
        $product->sub_category_id = $request->sub_category_id;
        $product->save();

        return $product;
    }

    public function update(ProductValidationRequest $request,  Product $product): Product
    {
        $product->update($request->all());

        return $product;
    }
}
