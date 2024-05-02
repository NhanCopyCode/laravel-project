<?php

namespace App\Providers;

use App\Models\Brand;
use App\Models\Branch;
use App\Models\BrandStatus;
use App\Models\ModelStatus;
use App\Models\BranchStatus;
use App\Models\PaymentMethod;
use App\Models\VehicleStatus;
use App\Models\CarRentalStore;
use Illuminate\Support\Facades\DB;
use App\Models\admins\ModelVehicle;
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

            $model_list = ModelVehicle::select(
                '*',
                DB::raw("CONCAT(models.model_name, ' - ', models.engine_type, ' - ', models.color, ' - ', models.year_of_production) as model_type")
            )->get();

            $carrentalstore_list = DB::table('carrentalstore')
            ->join('location', 'location.location_id', '=', 'carrentalstore.location_id')
            ->select('carrentalstore.*', 'location.*')
            ->get();

            $vehicle_status_list = VehicleStatus::all();

            $location_list = DB::table('carrentalstore')
                ->join('location', 'location.location_id', '=', 'carrentalstore.location_id')
                ->select('carrentalstore.*', 'location.*')
                ->get();

            $payment_method_list = PaymentMethod::all();
            


            $view->with(compact(
                'branch_status_list', 
                'brand_status_list', 
                'brand_list',
                'model_status_list',
                'branch_list',
                'model_list',
                'carrentalstore_list',
                'vehicle_status_list',
                'location_list',
                'payment_method_list',
            ));
        });
    }
}
