<?php

namespace App\Http\Requests\Api\V1\Product\Filter\Filters;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class Name implements FilterInterface
{
    public function apply(Builder $builder, Request $request): Builder
    {
        if ($name = $request->name) {
            $builder = $builder->where(Product::NAME, 'LIKE', '%' . $name . '%');
        }

        return $builder;
    }
}