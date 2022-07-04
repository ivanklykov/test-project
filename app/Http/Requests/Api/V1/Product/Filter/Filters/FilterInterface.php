<?php

namespace App\Http\Requests\Api\V1\Product\Filter\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

interface FilterInterface
{
    public function apply(Builder $builder, Request $request): Builder;
}