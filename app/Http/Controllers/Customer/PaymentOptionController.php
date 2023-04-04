<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentOptionController extends Controller
{
    public function getPaymentOptionsPerUser()
    {
        $paymentOptions = PaymentMethod::where('user_id', auth()->user()->id)->get();
        return response()->json($paymentOptions);
    }

    public function store(Request $request)
    {
        $request->validate([
            'payment_type' => 'required',
        ]);

        PaymentMethod::create([
            'user_id' => auth()->user()->id,
            'payment_type' => $request->payment_type,
            'extra_info' => $request->extra_info,
        ]);

        return response()->json(['message' => 'Payment option added successfully']);
    }

    public function destroy(PaymentMethod $paymentOption)
    {
        // check if the payment option exists for the user before deleting it
        $payment = PaymentMethod::where('user_id', auth()->user()->id)
            ->where('id', $paymentOption->id)
            ->first();

        if ($payment) {
            $payment->delete();
            return response()->json(['message' => 'Payment option deleted successfully']);
        }

        return response()->json(['message' => 'Payment option not found'], 404);
    }
}