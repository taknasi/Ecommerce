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
     * @return array
     */
    public function rules()
    {
        return [
            'slug'=>'required|unique:products,slug,'.$this->id,
            'name'=>'required|max:100',
            'description' => 'required',
            'short_description'=> 'nullable',
            'categories'=>'array|min:1',
            'categories.*' => 'numeric|exists:categories,id',
            'tags'=>'nullable|array',
            'brand_id'=>'required|exists:brands,id'
        ];
    }
}
