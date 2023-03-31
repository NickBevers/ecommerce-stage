<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PromoValidationRequest;
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

    public function store(PromoValidationRequest $request)
    {
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

    public function update(PromoValidationRequest $request, Promo $promo)
    {
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