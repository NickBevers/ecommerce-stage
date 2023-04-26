<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductReturnRequest;
use App\Models\ProductReturn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function store(ProductReturnRequest $request)
    {
        $return = ProductReturn::create([
            'user_id' => Auth::user()->id,
            'order_id' => $request->order_id,
            'sku_id' => $request->sku_id,
            'amount' => $request->amount,
            'reason' => $request->reason,
        ]);

        return redirect()->route('returns.show', $return->id);
    }

    public function show(ProductReturn $return)
    {
        return Inertia::render('Returns/Detail', [
            'return' => $return->with('sku')->first(),
        ]);
    }
}