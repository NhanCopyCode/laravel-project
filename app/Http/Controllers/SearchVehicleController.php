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
        if($request->has('form_search_vehicle_available')) {
            dd(';X');
            $validatedData = $request->validated();
        
            $vehicleStatusId = DB::table('VehicleStatus')
            ->where('vehicle_status_name', 'Hoạt động')
            ->select('vehicle_status_id')
            ->first()->vehicle_status_id;

            $vehicle_list = DB::table('Vehicles AS v')
            ->join('CarRentalStore AS crs', 'v.CarRentalStore_id', '=', 'crs.CarRentalStore_Id')
            ->join('models', 'models.model_id', '=', 'v.model_id')
            ->join('vehiclestatus', 'vehiclestatus.vehicle_status_id', '=', 'v.vehicle_status_id')
            ->join('vehicleimages', 'vehicleimages.vehicle_img_id', '=', 'v.vehicle_image_id')
            ->leftJoin('Rental AS r', function ($join) use ($request) {
                $join->on('v.vehicle_id', '=', 'r.vehicle_id')
                ->where(function ($query) use ($request) {
                    $query->where('r.rental_end_date', '<', $request->end_date)
                    ->orWhere('r.rental_start_date', '>',  $request->start_date)
                    ->orWhereNull('r.rental_id');
                });
            })
            ->where('crs.location_id', $request->location_id)
            ->where('v.vehicle_status_id', $vehicleStatusId)
            ->select('crs.*', 'v.*', 'vehicleimages.*', 'models.*','vehiclestatus.*')
            ->get();


            // dd($vehicle_available);
            return view('clients.home', compact('vehicle_list'));
        }
    }
}
