<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressValidationRequest;
use App\Models\Address;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AddressController extends Controller
{
    public function getAddressesPerUser()
    {
        return Address::where('user_id', auth()->user()->id)->get();
    }

    public function store(AddressValidationRequest $request)
    {
        $request->merge(['user_id' => Auth::user()->id]);
        $address = Address::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Address created successfully',
            'address' => $address,
        ]);
    }

    public function update(AddressValidationRequest $request, Address $shippingAddress)
    {
        $shippingAddress->update($request->all());

        return response()->json($shippingAddress);
    }

    public function destroy(Address $address)
    {
        ray($address);
        Address::where('id', $address->id)->delete();
        $address->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Address deleted successfully',
        ]);
    }
}