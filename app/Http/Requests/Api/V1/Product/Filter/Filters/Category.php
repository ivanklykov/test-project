<?php

namespace App\Http\Requests\Api\V1\Product\Filter\Filters;

use App\Models\{Product, Category as CategoryModel};
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class Category implements FilterInterface
{
    public function apply(Builder $builder, Request $request): Builder
    {
        if ($categoryName = $request->category_name) {
            $builder = $this->applyCategoryQueryFilter(
                $builder,
                CategoryModel::NAME,
                $categoryName
            );
        }

        if ($categoryId = $request->category_id) {
            $builder = $this->applyCategoryQueryFilter(
                $builder,
                CategoryModel::ID,
                $categoryId
            );
        }

        return $builder;
    }

    private function applyCategoryQueryFilter(Builder $builder, string $field, $value): Builder
    {
        return $builder->where(function ($query) use ($field, $value) {
            $query->whereHas('categories', function ($subQuery) use ($field, $value) {
                $subQuery->where($field, $value);
            });
        });
    }
}