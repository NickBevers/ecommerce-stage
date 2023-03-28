<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductReturn;
use Illuminate\Http\Request;

class ProductReturnController extends Controller
{
    public function index()
    {
        return ProductReturn::all();
    }

    public function update(Request $request, Int $id)
    {
        $return = ProductReturn::find($id);
        $return->update($request->all());
        return $return;
    }

    public function updateStatus(Request $request){
        $request->validate([
            'id' => 'required',
            'status' => 'required',
        ]);

        $produtReturn = ProductReturn::find($request->id);
        $produtReturn->status = $request->status;
        $produtReturn->save();

        return $produtReturn;
    }
}