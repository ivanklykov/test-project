<?php

namespace App\Http\Requests\Api\V1;

class CategoryRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255'
        ];
    }
}