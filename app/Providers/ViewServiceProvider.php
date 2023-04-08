<?php

namespace App\Providers;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view::composer(['home.layouts.home'], function ($view) {
            $view->with('parentCategories', Category::getParentCategory());
        });
        view::composer(['home.index'], function ($view) {
            $view->with('products', Product::getAllProducts());
        });
    }
}
