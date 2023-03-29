<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductReturn;
use Illuminate\Http\Request;

class ProductReturnController extends Controller
{

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

        $productReturn = ProductReturn::find($request->id);
        $productReturn->status = $request->status;
        $productReturn->save();

        return $productReturn;
    }
}