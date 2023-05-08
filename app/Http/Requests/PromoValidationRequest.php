<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PromoValidationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'sku_id' => 'required',
            'start_date' => 'required',
            'new_price' => 'required',
            'extra_info' => 'max:1000',
        ];
    }
}
