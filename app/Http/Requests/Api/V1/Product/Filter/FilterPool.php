<?php

namespace App\Http\Requests\Api\V1\Product\Filter;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\Api\V1\Product\Filter\Filters\FilterInterface;

class FilterPool
{
    public function __construct(private array $filters) {

    }

    public function applyFilters(Product $productModel, Request $request)
    {
        $builder = $productModel::query();

        /** @var FilterInterface $filter */
        foreach ($this->filters as $filter) {
            $builder = $filter->apply($builder, $request);
        }

        return $builder;
    }
}