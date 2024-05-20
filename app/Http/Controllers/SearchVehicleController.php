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

    public function searchVehicleAdvanced(Request $request)
    {
        // dd($request->all());

        $colors = $request->get('colors', []);
        $engine_type = $request->get('engine_type', []);
        $models = $request->get('models', []);

        $start_date = null;
        $end_date = null;

        if ($request->search_vehicle_daterange) {
            $search_vehicle_daterange = $request->search_vehicle_daterange;
            $dates = explode(" - ", $search_vehicle_daterange);
            $start_date = $dates[0];
            $end_date = $dates[1];
        }

        $query = DB::table('vehicles')
            ->join('models', 'models.model_id', '=', 'vehicles.model_id')
            ->join('vehicleimages', 'vehicleimages.vehicle_img_id', '=', 'vehicles.vehicle_image_id')
            ->join('carrentalstore', 'carrentalstore.carrentalstore_id', '=', 'vehicles.carrentalstore_id')
            ->join('vehiclestatus', 'vehiclestatus.vehicle_status_id', '=', 'vehicles.vehicle_status_id')
            ->select('vehicles.*', 'vehicleimages.*', 'models.*', 'vehiclestatus.*', 'carrentalstore.*');

        // Apply location_id filter first (prioritized)
        if ($request->location_id !== null) {
            $query->where('carrentalstore.location_id', '=', $request->location_id);
        }

        // Apply date filter if provided
        $query->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
            $query->leftJoin('rental', function ($join) use ($start_date, $end_date) {
                $join->on('vehicles.vehicle_id', '=', 'rental.vehicle_id')
                    ->where(function ($query) use ($start_date, $end_date) {
                        // Vehicle unavailable if booked within desired timeframe
                        $query->whereBetween('rental.rental_start_date', [$start_date, $end_date])
                            ->orWhereBetween('rental.rental_end_date', [$start_date, $end_date]);
                    });
            })
                ->whereNull('rental.rental_id'); // No overlapping bookings
        });

        // Apply color filters (optional)
        if (!empty($colors)) {
            $query->where(function ($query) use ($colors) {
                foreach ($colors as $color) {
                    $query->orWhere('models.color', 'like', '%' . $color . '%');
                }
            });
        }

        // Apply engine_type filters (optional)
        if (!empty($engine_type)) {
            $query->where(function ($query) use ($engine_type) {
                foreach ($engine_type as $engine) {
                    $query->orWhere('models.engine_type', 'like', '%' . $engine . '%');
                }
            });
        }

        // Apply model filters (optional)
        if (!empty($models)) {
            $query->where(function ($query) use ($models) {
                foreach ($models as $model) {
                    $query->orWhere('models.model_name', 'like', '%' . $model . '%');
                }
            });
        }

        $page = $request->get('page', 1); // Default to page 1

        $per_page = $request->get('per_page', 3); // Default to 10 results per page

        $offset = ($page - 1) * $per_page; // Calculate offset for pagination

        $query = $query->skip($offset)->take($per_page); // Apply pagination

        $vehicle_available = $query->distinct()->get();

        $vehicle_number = $vehicle_available->count();

        $total_pages = ceil($vehicle_number / $per_page);


        if ($vehicle_number > 0) {
            return response()->json([
                'status' => 'success',
                'vehicle_available' => $vehicle_available,
                'vehicle_number' => $vehicle_number,
                'total_pages' => $total_pages,
                'current_page' => $page,
                'per_page' => $per_page,
            ]);
        } else {
            return response()->json([
                'status' => 'not found',
                'message' => 'Không tìm thấy xe nào rảnh',
            ]);
        }
    }


    public function searchVehicleAdvancedDate(Request $request)
    {
        $start_date = null;
        $end_date = null;

        if($request->search_vehicle_daterange) {
            $search_vehicle_daterange = $request->search_vehicle_daterange;
            $dates = explode(" - ", $search_vehicle_daterange);
            $start_date = $dates[0];
            $end_date = $dates[1];
        }

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
        
        if($vehicles->count() > 0) {
            return response()->json([
                'status' => 'success',
                'vehicle_available' => $vehicles,
                'search_advanced_date' => 'oke',
            ]);
        }else {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy xe nào rảnh',
            ]);
        }

    }
}
