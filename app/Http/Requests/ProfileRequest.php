<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'name' =>'required|min:5',
            'email' => 'required|email|unique:admins,email,'.$this->id,
            'password' => 'nullable|required_with:password_confirmation|confirmed|min:6',
            'password_confirmation' => 'nullable|required_with:password|min:6'
        ];
    }
}
