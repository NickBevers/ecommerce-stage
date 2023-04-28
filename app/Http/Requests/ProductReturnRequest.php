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
            'order_id' => 'required',
            'sku_id' => 'required',
            'amount' => 'numeric',
            'reason' => 'required',
        ];
    }
}