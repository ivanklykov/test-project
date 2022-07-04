<?php

namespace App\Http\Requests\Api\V1\Product\Filter\Filters;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PriceRange implements FilterInterface
{
    public function apply(Builder $builder, Request $request): Builder
    {
        if ($priceFrom = $request->price_from) {
            $builder->where(Product::PRICE, '>', $priceFrom);
        }

        if ($priceTo = $request->price_to) {
            $builder->where(Product::PRICE, '<', $priceTo);
        }

        return $builder;
    }
}