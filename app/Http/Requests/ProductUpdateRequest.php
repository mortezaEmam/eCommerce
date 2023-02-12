<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'brand_id' =>'required|integer|exists:brands,id',
            'is_active' =>'required|integer',
            'description' =>'nullable|string',
            'tag_ids' =>'required',
            'tag_ids.*' =>'int|exists:tags,id',
            'Attribute_value'=>'required',
            'Attribute_value.*'=>'required ',
            'variation_values.*.price'=>'required|integer',
            'variation_values.*.quantity'=>'required|integer',
            'variation_values.*.sale_price'=>'nullable|integer',
            'variation_values.*.date_on_sale_from'=>'nullable|date',
            'variation_values.*.date_on_sale_to'=>'nullable|date',
            'delivery_amount' =>'required|integer',
            'delivery_amount_per_product' =>'nullable|integer'
        ];
    }
}
