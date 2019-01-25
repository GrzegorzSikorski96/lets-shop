<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddProduct extends FormRequest
{

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
            'name' => 'required|max:40',
            'category_id' => 'integer|nullable',
            'shop_id' => 'integer|nullable',
            'description' => 'nullable|max:100'
        ];
    }
}
