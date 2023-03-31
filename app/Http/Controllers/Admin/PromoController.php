<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use App\Models\Sku;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PromoController extends Controller
{
    public function create(String $skuId)
    {
        $sku = Sku::where('id', $skuId)->withAllRelations()->first();

        return Inertia::render('Admin/Promos/Create')->with('sku', $sku);
    }

    public function store(Request $request)
    {
        // TODO: validate the request and put it in a request class
        $request->validate([
            'sku_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'new_price' => 'required',
            'extra_info' => 'String,max:1000',
        ]);

        Promo::create($request->all());

        return redirect()
            ->route('products.index')
            ->with('success', 'Promo created successfully.');
    }

    public function edit(Promo $promo)
    {
        return Inertia::render('Admin/Promos/Edit', [
            'promo' => $promo,
        ]);
    }

    public function update(Request $request, Promo $promo)
    {
        // TODO: validate the request and put it in a request class
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