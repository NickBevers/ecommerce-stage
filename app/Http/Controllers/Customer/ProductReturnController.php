<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\ProductReturn;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductReturnController extends Controller
{
    public function getReturnByUser()
    {
        $returns = ProductReturn::where('user_id', auth()->user()->id)->get();
        return Inertia::render('Returns/Index', [
            'returns' => $returns,
        ]);
    }

    public function store(Request $request)
    {
        $return = ProductReturn::create($request->all());

        return redirect()->route('returns.show', $return->id);
    }

    public function show(ProductReturn $return)
    {
        return Inertia::render('Returns/Detail', [
            'return' => $return->with('sku')->first(),
        ]);
    }
}