<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Product\ProductController;
use App\Models\Promo;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index()
    {
        
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        ProductController::setPromotionStatus($request->id);
    }

    public function show(Promo $promo)
    {
    }

    public function edit(Promo $promo)
    {
    }

    public function update(Request $request, Promo $promo)
    {
    }

    public function destroy(Promo $promo)
    {
    }
}