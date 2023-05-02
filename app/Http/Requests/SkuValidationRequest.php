<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SkuValidationRequest extends FormRequest
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
     * @return array
     */
    public function rules(): array
    {
        return [
            'product_id' => 'required|integer',
            'brand_id' => 'required|integer',
        ];
    }
}
