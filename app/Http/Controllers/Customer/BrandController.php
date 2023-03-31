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
        return Inertia::render('Customer/Brands/Index', [
            'brands' => Brand::all()->map(function ($brand) {
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
            'brand' => $brand,
            'skus' => Sku::whereHas('product', function ($query) use ($brand) {
                $query->where('brand_id', $brand->id);
            })->with('product')->paginate(48)
        ]);
    }
}