<?php

namespace App\Http\Requests\Api\V1;

class ProductRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|gt:0',
            'categories' => 'required|array|min:2|max:4|exists:category,id'
        ];
    }
}