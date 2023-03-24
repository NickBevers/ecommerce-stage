<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\ShippingAddress;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function getAddressesPerUser()
    {
        return Address::where('user_id', auth()->user()->id)->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'address_line1' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            'address_type' => 'required',
            'country' => 'required',
        ]);

        $request->merge(['user_id' => auth()->user()->id]);
        $address = Address::create($request->all());

        return redirect()->route('shipping-addresses.index')->with('success', 'Shipping Address created successfully')->with('address', $address);
    }

    public function update(Request $request, Address $shippingAddress)
    {
        $shippingAddress->update($request->all());

        return redirect()
            ->back()
            ->with('success', 'Shipping Address updated successfully');

    }

    public function destroy(Address $shippingAddress): RedirectResponse
    {
        $shippingAddress->delete();

        return redirect()
            ->back()
            ->with('success', 'Shipping Address deleted successfully');
    }
}