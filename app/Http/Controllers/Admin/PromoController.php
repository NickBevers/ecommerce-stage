<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PromoValidationRequest;
use App\Models\Promo;
use App\Models\Sku;
use App\Models\Vat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
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
        $request = $this->formatPromotionData($sku, $request);

        $promo = new Promo();
        $promo->sku_id = $request->sku_id;
        $promo->new_price_excl_vat = $request->new_price_excl_vat;
        $promo->new_price_incl_vat = $request->new_price_incl_vat;
        $promo->start_date = Date::create($request->start_date);
        $promo->end_date = Date::create($request->end_date);
        $promo->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Promo created successfully.'
        ]);
    }

    public function storeAllVariations(PromoValidationRequest $request){
        $sku = Sku::where('id', $request->sku_id)->first();
        $skus = $sku->product->skus;
        $request = $this->formatPromotionData($sku, $request);

        foreach($skus as $sku){
            $promo = new Promo();
            $promo->sku_id = $sku->id;
            $promo->new_price_excl_vat = $request->new_price_excl_vat;
            $promo->new_price_incl_vat = $request->new_price_incl_vat;
            $promo->start_date = Date::create($request->start_date);
            $promo->end_date = Date::create($request->end_date);
            $promo->save();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Promo created successfully.'
        ]);
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

    /**
     * @param Sku $sku
     * @param PromoValidationRequest $request
     * @return Request $newRequest
     */
    private function formatPromotionData(Sku $sku, PromoValidationRequest $request): Request
    {
        $vat = Vat::where('id', $sku->vat_id)->first()->vat_rate;

        $priceExclVat = $request->new_price;
        $priceInclVat = $priceExclVat * (1 + $vat / 100);

        $request->merge([
            'new_price_excl_vat' => $priceExclVat,
            'new_price_incl_vat' => $priceInclVat,
        ]);
        $request->offsetUnset('new_price');

        if ($request->end_date === '' || $request->end_date === null) {
            $request->offsetUnset('end_date');
            $request->merge([
                'end_date' => Date::now()->addYears(10),
            ]);
        } else {
            $date = $request->end_date;
            $request->offsetUnset('end_date');
            $request->merge([
                'end_date' => Date::create($date)->endOfDay(),
            ]);
        }

        return $request;
    }
}