<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        Brand::all();
    }

    public function show($brand)
    {
        ray($brand);
        return Brand::where('name', $brand)->firstOrFail();
    }
}