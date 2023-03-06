<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    public function index()
    {
    }

    public function create()
    {

    }

    public function store(String $image, $id)
    {
        $productImage = new ProductImage();
        $productImage->product_id = $id;
        $productImage->image_type = 'main';
        $productImage->image_link = $image;
        $productImage->image_public_id = `/images/${$image}`;
        $productImage->alt = 'ProductImage';
        $productImage->save();
    }

    public function show(ProductImage $productImage)
    {
    }

    public function edit(ProductImage $productImage)
    {
    }

    public function update(Request $request, ProductImage $productImage)
    {
    }

    public function destroy(ProductImage $productImage)
    {
    }
}