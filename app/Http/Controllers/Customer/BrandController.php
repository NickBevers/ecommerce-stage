<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Product\SkuController;
use App\Models\Brand;
use App\Models\Sku;
use App\Services\SkuService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BrandController extends Controller
{

    private SkuService $skuService;

    public function __construct()
    {
        $this->skuService = new SkuService();
    }

    public function index()
    {
        // get all brands where there is at least one sku tied to the product of the brand
        $brands = Brand::whereHas('products.skus')->get();
        return Inertia::render('Customer/Brands/Index', [
            'brands' => $brands->map(function ($brand) {
                return [
                    'id' => $brand->id,
                    'name' => $brand->name,
                    'slug' => $brand->slug,
                ];
            }),
        ]);
    }

    public function show(Brand $brand)
    {
        return Inertia::render('Customer/Brands/Overview', [
            'brand' => Brand::where('id', $brand->id)->with('skus')->first(),
            'skus' => Sku::whereHas('product.brand', function ($query) use ($brand) {
                $query->where('id', $brand->id);
            })->withAllRelations()->paginate(48),
        ]);
    }
}