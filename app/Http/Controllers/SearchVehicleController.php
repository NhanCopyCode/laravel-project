<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\SearchVehicleClient;

class SearchVehicleController extends Controller
{
    //
    public function searchVehicle(SearchVehicleClient $request)
    {   
        // dd($request->all());
        $search_vehicle_daterange = $request->search_vehicle_daterange;
        $dates = explode(" - ", $search_vehicle_daterange);
        $start_date = $dates[0];
        $end_date = $dates[1];

        if($request->has('search_vehicle_daterange')) {
            $validatedData = $request->validated();
        
            $vehicleStatusId = DB::table('VehicleStatus')
            ->where('vehicle_status_name', 'Hoạt động')
            ->select('vehicle_status_id')
            ->first()->vehicle_status_id;

            // $vehicles = DB::table('vehicles')
            // ->distinct()
            // ->join('carrentalstore', 'vehicles.CarRentalStore_id', '=', 'carrentalstore.CarRentalStore_id')
            // ->join('models', 'models.model_id', '=', 'vehicles.model_id')
            // ->join('rental', 'rental.vehicle_id', '=', 'vehicles.vehicle_id')
            // ->join('vehicleimages', 'vehicleimages.vehicle_img_id', '=', 'vehicles.vehicle_image_id')
            // ->join('vehiclestatus', 'vehiclestatus.vehicle_status_id', '=', 'vehicles.vehicle_status_id')
            // ->where(function ($query) use ($start_date, $end_date) {
            //     $query->where('rental.rental_start_date', '<=', $start_date)
            //         ->where('rental.rental_end_date', '<=', $end_date);
            // })
            // ->orWhere(function ($query) use ($start_date, $end_date){
            //     $query->where('rental.rental_end_date', '>=', $start_date)
            //         ->where('rental.rental_start_date', '>=', $end_date);
            // })
            // ->where('carrentalstore.location_id', '=', 32)
            // ->select('vehicles.*', 'vehicleimages.*', 'models.*', 'vehiclestatus.*')
            // ->get();

            //
            $vehicles = DB::table('vehicles')
            ->join('carrentalstore', 'vehicles.CarRentalStore_id', '=', 'carrentalstore.CarRentalStore_id')
            ->join('models', 'models.model_id', '=', 'vehicles.model_id')
            ->join('vehicleimages', 'vehicleimages.vehicle_img_id', '=', 'vehicles.vehicle_image_id')
            ->join('vehiclestatus', 'vehiclestatus.vehicle_status_id', '=', 'vehicles.vehicle_status_id')
            ->leftJoin('rental', function($join) use ($start_date, $end_date) {
                $join->on('vehicles.vehicle_id', '=', 'rental.vehicle_id')
                    ->where(function($query) use ($start_date, $end_date) {
                        // Xe được coi là không khả dụng nếu có booking cắt ngang khoảng thời gian mong muốn
                        $query->whereBetween('rental.rental_start_date', [$start_date, $end_date])
                            ->orWhereBetween('rental.rental_end_date', [$start_date, $end_date]);
                    });
            })
            ->whereNull('rental.rental_id') // Xe không có booking nào trùng lặp
            ->where('carrentalstore.location_id', '=', $request->location_id)
            ->select('vehicles.*', 'vehicleimages.*', 'models.*', 'vehiclestatus.*')
            ->distinct()
            ->get();
        

        
        
            // dd($vehicle_available);
            return view('clients.home', compact('vehicles', 'vehicleStatusId'));
        }
    }
}
