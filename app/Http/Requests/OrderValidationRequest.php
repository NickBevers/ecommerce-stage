<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderValidationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required',
            'shipping_address_id' => 'required',
            'preferred_delivery_date' => 'required',
            'billing_adress_id' => 'String',
            'payment_method' => 'required',
            'skus' => 'array|required',
        ];
    }
}