<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\UserPaymentMethod;
use App\Models\PaymentType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PaymentTypeController extends Controller
{
    public function index()
    {
        return PaymentType::all();
    }

//    public function store(Request $request)
//    {
//        $request->validate([
//            'payment_type_id' => 'required',
//        ]);
//
//        $request->merge([
//            'extra_info' => $request->extra_info ?? null,
//        ]);
//
//        UserPaymentMethod::create([
//            'user_id' => auth()->user()->id,
//            'payment_type_id' => $request->payment_type_id,
//            'extra_info' => $request->extra_info,
//        ]);
//
//        return response()->json(['message' => 'Payment option added successfully']);
//    }
//
//    public function destroy(UserPaymentMethod $paymentMethod, PaymentType $paymentType)
//    {
//        $payment = UserPaymentMethod::where('user_id', auth()->user()->id)
//            ->where('id', $paymentType->id)
//            ->first();
//
//        if ($payment) {
//            $payment->delete();
//            return response()->json(['message' => 'Payment option deleted successfully']);
//        }
//
//        return response()->json(['message' => 'Payment option not found'], 404);
//    }
}