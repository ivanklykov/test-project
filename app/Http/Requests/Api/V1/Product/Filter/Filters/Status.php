<?php

namespace App\Http\Requests\Api\V1\Product\Filter\Filters;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class Status implements FilterInterface
{
    public function apply(Builder $builder, Request $request): Builder
    {
        $status = $request->status ?? null;

        if ($status !== null) {
            $builder = $builder->where(Product::STATUS, (bool) $status);
        }

        return $builder;
    }
}