<?php

namespace App\Http\Controllers;

use App\Models\ShippingAddress;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ShippingAddressesController extends Controller
{
    public function index()
    {
    }

    public function create()
    {
    }


    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'address_line1' => 'required',
            'address_line2' => 'nullable',
            'city' => 'required',
            'postal_code' => 'required',
            'country' => 'required',
        ]);

        $shippingAddress = new ShippingAddress();
        $shippingAddress->user_id = $request->user_id;
        $shippingAddress->address_line1 = $request->address_line1;
        $shippingAddress->address_line2 = $request->address_line2;
        $shippingAddress->city = $request->city;
        $shippingAddress->postal_code = $request->postal_code;
        $shippingAddress->country = $request->country;
        $shippingAddress->save();

        return redirect()->route('shipping-addresses.index');
    }

    public function show(ShippingAddress $shippingAddress)
    {
    }

    public function edit(ShippingAddress $shippingAddress)
    {
    }

    public function update(Request $request, ShippingAddress $shippingAddress): redirectResponse
    {
        $shippingAddress->update($request->all());

        return redirect()
            ->back()
            ->with('success', 'Shipping Address updated successfully');

    }

    public function destroy(ShippingAddress $shippingAddress): RedirectResponse
    {
        $shippingAddress->delete();

        return redirect()
            ->back()
            ->with('success', 'Shipping Address deleted successfully');
    }
}