<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Requests\Api\V1\Product\Filter\FilterPool;
use App\Http\Requests\Api\V1\Product\Filter\Filters\{
    Archived, Category, PriceRange, Status, Name
};

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->tag(
            [
                Archived::class,
                Category::class,
                Name::class,
                PriceRange::class,
                Status::class
            ],
            'productFilters'
        );

        $this->app->when(FilterPool::class)
            ->needs('$filters')
            ->giveTagged('productFilters');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
