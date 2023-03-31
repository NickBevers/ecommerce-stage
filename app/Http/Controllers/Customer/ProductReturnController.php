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
        // TODO: validate the request and put it in a request class
        $request->validate([
            'user_id' => 'required',
            'order_id' => 'required',
            'sku_id' => 'required',
            'quantity' => 'required',
            'reason' => 'required',
            'status' => 'required',
        ]);

        $return = ProductReturn::create($request->all());

        return redirect()->route('returns.show', $return->id);
    }

    public function show(Int $id)
    {
        $return = ProductReturn::where('id', $id)
            ->withSku()
            ->first();


        return Inertia::render('Returns/Detail', [
            'return' => $return,
        ]);
    }
}