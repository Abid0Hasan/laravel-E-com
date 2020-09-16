<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Product extends FormRequest
{

    public function authorize()
    {
        return false;
    }


    public function rules()
    {
        return [

            'name' => 'required|max:255|unique:products',
            'category_id' => 'id',
            'description' => 'required',
            'price' => 'required|max:10',
            'stock' => 'required|max:6',
            'discount' => 'required|max:2'
        ];
    }
}
