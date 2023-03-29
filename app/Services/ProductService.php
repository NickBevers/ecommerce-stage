<?php

namespace App\Services;

use App\Http\Requests\ProductValidationRequest;
use App\Models\Product;
class ProductService
{
    public function store(ProductValidationRequest $request): Product
    {
        $product = Product::create($request->all());
        $product->save();

        return $product;
    }

    public function update(ProductValidationRequest $request,  Product $product): Product
    {
        $product->update($request->all());

        return $product;
    }
}
