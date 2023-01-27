<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'brand_id' =>'required|integer',
            'is_active' =>'required|integer',
            'description' =>'nullable|string',
            'tag_ids' =>'required',
            'tag_ids.*' =>'int',
            'primary_image' =>'required|mimes:jpg,jpeg,svg,png',
            'images' =>'required',
            'images.*' =>'mimes:jpg,jpeg,svg,png',
            'category_id' =>'required|integer',
            'attribute_ids' =>'required',
            'attribute_ids.*' =>'required',
            'attribute_variation'=>'required',
            'attribute_variation.*.*'=>'required',
            'attribute_variation.price.*'=>'integer',
            'attribute_variation.quantity.*'=>'integer',
            'delivery_amount' =>'required|integer',
            'delivery_amount_per_product' =>'nullable|integer'
        ];
    }
}
