<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductReturnRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required',
            'order_id' => 'required',
            'sku_id' => 'required',
            'quantity' => 'required',
            'reason' => 'required',
            'status' => 'required',
        ];
    }
}