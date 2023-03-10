<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Product\ProductController;
use App\Models\Promo;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PromoController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Promos/Index');
    }

    public function create()
    {
        return Inertia::render('Admin/Promos/Create');
    }

    public function store(Request $request)
    {
        // create a new promo after validating the request
        $request->validate([
            'sku_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'new_price' => 'required',
            'extra_info' => 'String,max:1000',
        ]);

        Promo::create([
            'sku_id' => $request->sku_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'new_price' => $request->new_price,
            'extra_info' => $request->extra_info,
        ]);

        return redirect()
            ->route('products.index')
            ->with('success', 'Promo created successfully.');
    }

    public function show(Promo $promo)
    {
    }

    public function edit(Promo $promo)
    {
        return Inertia::render('Admin/Promos/Edit', [
            'promo' => $promo,
        ]);
    }

    public function update(Request $request, Promo $promo)
    {
        $request->validate([
            'sku_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'new_price' => 'required',
            'extra_info' => 'String,max:1000',
        ]);

        //patch the promo
        $promo->fill($request->all());
        $promo->save();

        return redirect()
            ->route('products.index')
            ->with('success', 'Promo updated successfully.');
    }

    public function destroy(Promo $promo)
    {
        $promo->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Promo deleted successfully.');
    }
}