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

    public function updateStatus(Int $id, String $status){
        $produtReturn = ProductReturn::find($id);
        $produtReturn->status = $status;
        $produtReturn->save();

        return $produtReturn;
    }
}