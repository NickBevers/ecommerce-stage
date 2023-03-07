<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {

    }

    public function getAllBrands()
    {
        return Brand::all()->map(function ($brand) {
            return [
                'id' => $brand->id,
                'name' => $brand->name,
                'slug' => $brand->slug,
            ];
        });
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show(Brand $brand)
    {
    }

    public function edit(Brand $brand)
    {
    }

    public function update(Request $request, Brand $brand)
    {
    }

    public function destroy(Brand $brand)
    {
    }
}