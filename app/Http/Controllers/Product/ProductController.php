<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        return Product::all();

    }

    public function testFunction()
    {
        return "Works";
    }

    public function show(Product $product)
    {
        return Inertia::render('products/show', [
            'product' => $product
        ]);
    }

    public function getStatus(Product $product)
    {
        return $product->is_active;
    }

    public function setStatus(Product $product)
    {
        $product->is_active = !$product->is_active;
        $product->save();
        return $product->is_active;
    }

    public function getPromotionStatus(Product $product)
    {
        return $product->is_promotion;
    }

    public function setPromotionStatus(Product $product)
    {
        $product->is_promotion = !$product->is_promotion;
        $product->save();
        return $product->is_promotion;
    }
}