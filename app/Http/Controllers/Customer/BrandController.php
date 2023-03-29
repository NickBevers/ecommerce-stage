<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Product\SkuController;
use App\Models\Brand;
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

    public function show($brand)
    {
        $request = new Request();
        $request->merge(['brand' => $brand]);
        return Inertia::render('Customer/Brands/Overview', [
            'brand' => Brand::where('slug', $brand)->first(),
            'skus' => $this->skuService->filter($request),
        ]);
    }
}