<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductCategoryRequest extends FormRequest
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
            'category_id' =>'required|exists:categories,id',
            'attribute_ids' =>'required',
            'attribute_ids.*' =>'required',
            'attribute_variation'=>'required',
            'attribute_variation.*.*'=>'required',
            'attribute_variation.*.price'=>'integer',
            'attribute_variation.*.quantity'=>'integer',
        ];
    }
}
