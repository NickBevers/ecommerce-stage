<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductValidationRequest extends FormRequest
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
            'title' => 'required',
            'description' => 'required',
            'audience' => 'required',
            'product_type' => 'required',
            'vat_id' => 'required',
            'brand_id' => 'required',
            'sub_category_id' => 'required',
            'variations' => 'required',
        ];
    }
}
