<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductReturn;
use Illuminate\Http\Request;

class ProductReturnController extends Controller
{
    public function index()
    {
        return ProductReturn::all();
    }

    public function show(ProductReturn $productReturn)
    {
    }
}