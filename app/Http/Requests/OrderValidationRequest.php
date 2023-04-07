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
            'total_price' => 'required',
            'shipping_address_id' => 'required|String',
            'billing_address_id' => 'String|nullable',
            'payment_type_id' => 'required',
            'skus' => 'array|required',
        ];
    }
}