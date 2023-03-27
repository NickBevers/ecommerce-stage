<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\PaymentOption;
use Illuminate\Http\Request;

class PaymentOptionController extends Controller
{
    public function getPaymentOptionsPerUser()
    {
        $paymentOptions = PaymentOption::where('user_id', auth()->user()->id)->get();
        return response()->json($paymentOptions);
    }

    public function store(Request $request)
    {
        $request->validate([
            'payment_type' => 'required',
        ]);

        PaymentOption::create([
            'user_id' => auth()->user()->id,
            'payment_type' => $request->payment_type,
            'extra_info' => $request->extra_info,
        ]);

        return response()->json(['message' => 'Payment option added successfully']);
    }

    public function destroy(String $id)
    {
        $paymentOption = PaymentOption::where('id', $id)->where('user_id', auth()->user()->id)->first();
        if (!$paymentOption) {
            return response()->json(['message' => 'Payment option not found'], 404);
        }

        $paymentOption->delete();
        return response()->json(['message' => 'Payment option deleted successfully']);
    }
}