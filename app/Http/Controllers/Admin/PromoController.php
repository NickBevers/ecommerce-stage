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
        $sku = Sku::where('id', $request->sku_id)->first();
        $vat = $sku->vat->vat_rate;

        $priceExclVat = $request->new_price;
        $priceInclVat = $priceExclVat * (1 + floatval($vat));

        $request->merge([
            'price_excl_vat' => $priceExclVat,
            'price_incl_vat' => $priceInclVat,
        ]);

        Promo::create($request->all());

        return redirect()
            ->route('products.index')
            ->with('success', 'Promo created successfully.');
    }

    public function storeAllVariations(PromoValidationRequest $request){
        $sku = Sku::where('id', $request->sku_id)->first();
        $skus = $sku->product->skus;
        $vat = $sku->vat->vat_rate;

        foreach($skus as $sku){
            $priceExclVat = $request->new_price;
            $priceInclVat = $priceExclVat * (1 + floatval($vat));

            $request->merge([
                'sku_id' => $sku->id,
                'price_excl_vat' => $priceExclVat,
                'price_incl_vat' => $priceInclVat,
            ]);

            Promo::create($request->all());
        }

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