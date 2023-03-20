<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\Sku;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Products/Index', [
            'skus' => Sku::with('attributeValues')
                ->with('product')
                ->orderBy('sku')
                ->paginate(10),
            'attributeValues' => AttributeValue::all(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Products/Create');
    }

    public function store(Request $request)
    {
        $product = Product::create($request->all());
        $product->save();

        return $product;
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

    public function edit(Product $product)
    {
        $productDetails = Product::find($product->id);

        return Inertia::render('products/edit', [
            'product' => $productDetails
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $productToUpdate = Product::find($product->id);
        $productToUpdate->update($request->all());
        $productToUpdate->save();
        return $productToUpdate;
    }

    public function destroy(Product $product)
    {
        $product->delete();
    }
}