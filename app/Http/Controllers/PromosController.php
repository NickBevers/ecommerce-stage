<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Promo;
use Illuminate\Http\Request;

class PromosController extends Controller
{
    public function index()
    {
        
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        ProductsController::setPromotionStatus($request->id);
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