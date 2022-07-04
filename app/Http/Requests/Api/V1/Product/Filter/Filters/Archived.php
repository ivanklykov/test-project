<?php

namespace App\Http\Requests\Api\V1\Product\Filter\Filters;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class Archived implements FilterInterface
{
    public function apply(Builder $builder, Request $request): Builder
    {
        $isArchive = $request->is_archive ?? null;

        if ($isArchive !== null) {
            $builder->where(Product::IS_ARCHIVE, $isArchive);
        }

        return $builder;
    }
}