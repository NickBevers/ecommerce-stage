<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\ProductReturn;
use Illuminate\Http\Request;

class ProductReturnController extends Controller
{
    public function index()
    {
        return ProductReturn::all();
    }

    public function store(Request $request)
    {
    }

    public function show(ProductReturn $productReturn)
    {
    }

    public function edit(ProductReturn $productReturn)
    {
    }

    public function update(Request $request, ProductReturn $productReturn)
    {
    }

    public function destroy(ProductReturn $productReturn)
    {
    }
}