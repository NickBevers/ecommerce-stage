<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressValidationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'address_line1' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            'address_type' => 'required',
            'country' => 'required',
        ];
    }

}