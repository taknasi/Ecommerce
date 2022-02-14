<?php

namespace App\Http\Requests;

use App\Rules\ProductQntRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductStockRequest extends FormRequest
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
            'sku'=>'nullable',
            'product_id'=>'required|exists:products,id',
            'manage_stock'=>'required|in:1,0',
            'in_stock' => 'required|in:1,0',
            'qty'=>[new ProductQntRule($this->manage_stock)]
        ];
    }
}
