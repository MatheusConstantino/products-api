<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'price' => 'required|numeric',
            'isbn' => 'required',
            'status' => 'boolean',
            'image_ids' => 'array|max:5'
        ];
    }
}

