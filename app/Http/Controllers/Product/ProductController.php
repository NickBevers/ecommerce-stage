<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductValidationRequest;
use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\Sku;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    private ProductService $productService;

    public function __construct()
    {
        $this->productService = new ProductService();
    }

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

    public function store(ProductValidationRequest $request)
    {
        $this->productService->store($request);
        return redirect()->route('admin.products.index');
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

    public function edit(Product $product)
    {
        $productDetails = Product::find($product->id);

        return Inertia::render('products/edit', [
            'product' => $productDetails
        ]);
    }

    public function update(ProductValidationRequest $request, Product $product)
    {
        $productToUpdate = Product::find($product->id);
        $productToUpdate->update($request->all());
        $productToUpdate->save();

        return $productToUpdate;
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index');
    }
}