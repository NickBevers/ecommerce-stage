<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressValidationRequest;
use App\Models\Address;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AddressController extends Controller
{
    public function getAddressesPerUser()
    {
        return Address::where('user_id', auth()->user()->id)->get();
    }

    public function store(AddressValidationRequest $request)
    {
        $request->merge(['user_id' => auth()->user()->id]);
        $address = Address::create($request->all());

        return response()->json($address);
    }

    public function update(AddressValidationRequest $request, Address $shippingAddress)
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