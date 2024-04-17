<?php

namespace App\Providers;

use App\Models\Brand;
use App\Models\Branch;
use App\Models\BrandStatus;
use App\Models\ModelStatus;
use App\Models\BranchStatus;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Paginator::useBootstrap();
        
        view()->composer('*', function($view) {

            $branch_status_list = BranchStatus::all();

            $brand_status_list = BrandStatus::all();

            $model_status_list = ModelStatus::all();

            $brand_list = Brand::all();

            $branch_list = Branch::all();

            $view->with(compact(
                 'branch_status_list', 
                'brand_status_list', 
                'brand_list',
                'model_status_list',
                'branch_list',
            ));
        });
    }
}
