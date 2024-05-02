<?php

namespace App\Http\Controllers\admins;

use App\Models\Vehicle;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\VehicleImages;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\VehicleRequest;

class VehicleController extends Controller
{
    //
    public function index()
    {
        // dd('xin chào');
        $vehicleList = DB::table('vehicles')
            ->join('models', 'models.model_id', '=', 'vehicles.model_id')
            ->join('vehiclestatus', 'vehiclestatus.vehicle_status_id', '=', 'vehicles.vehicle_status_id')
            ->join('vehicleimages', 'vehicleimages.vehicle_img_id', '=', 'vehicles.vehicle_image_id')
            ->join('carrentalstore', 'carrentalstore.CarRentalStore_id', '=', 'vehicles.CarRentalStore_id')
            ->join('location', 'location.location_id', '=', 'carrentalstore.Location_id')
            ->select(
                'vehicles.*',
                'vehicles.created_at as vehicle_created_at',
                'vehicles.description as vehicle_description',
                'vehicles.CarRentalStore_id as vehicle_carrentalstore_id',
                'carrentalstore.*',
                'models.*',
                'vehicleimages.*',
                'vehiclestatus.*',
                'location.*',
                DB::raw("CONCAT(models.model_name, ' - ', models.engine_type, ' - ', models.color, ' - ', models.year_of_production) as model_type"),
            )
            ->orderBy('vehicles.vehicle_id', 'asc')
            ->paginate(2);

        // $vehicleList = Vehicle::all();
        // dd($vehicleList);
        return view('admin.vehicle', compact('vehicleList'))->with('i', (request()->input('page', 1) - 1) * 5);
        // return view('admin.vehicle', compact('vehicleList'));
    }

    public function addvehicle(VehicleRequest $request)
    {
        // dd($request->CarRentalStore_id);

        $vehicle_image_data_1 = null;
        $vehicle_image_data_2 = null;
        $vehicle_image_data_3 = null;
        if ($request->hasfile('vehicle_image_name')) {
            $images = $request->file('vehicle_image_name');
            
            // dd($images);
            $image_arr = [];
            foreach ($images as $index => $image) {
                $fileName = Str::slug($request->license_plate) . '_' . time() . '.' . $image->getClientOriginalName(). '.' . $image->extension();
    
                // Store the image and retrieve the path
                $image->storeAs('vehicle/images', $fileName, 'public');
                $path = asset('storage/vehicle/images/' . $fileName);
    
        
                $image_arr[] = $path;
            }
        }

        foreach ($image_arr as $index => $path) {
            switch ($index) {
                case 0:
                    $vehicle_image_data_1 = $path;
                    break;
                case 1:
                    $vehicle_image_data_2 = $path;
                    break;
                case 2:
                    $vehicle_image_data_3 = $path;
                    break;
            }
        }

        $vehicle_image_id = VehicleImages::create([
            'vehicle_image_data_1' => $vehicle_image_data_1,
            'vehicle_image_data_2' => $vehicle_image_data_2,
            'vehicle_image_data_3' => $vehicle_image_data_3,
        ]);


        $vehicle = Vehicle::create([
            'CarRentalStore_id' => $request->CarRentalStore_id,
            'model_id' => $request->model_id,
            'description' => $request->vehicle_description,
            'rental_price_day' => $request->rental_price_day,
            'license_plate' => $request->license_plate,
            'vehicle_image_id' => $vehicle_image_id->vehicle_img_id,
            'vehicle_status_id' => $request->vehicle_status_id,
        ]);

        $list = Vehicle::all();
        if($vehicle) {
            return response()->json([
                'status' => 'success',
                'vehicle' => $list,
            ]);
        }else {
            return response()->json([
                'status' => 'error',
            ]);
        }
    }



    public function update(Request $request)
    {
        // return $request->all();
        $rules = [
            'CarRentalStore_id' => 'required|min:0',
            'model_id' => 'required|min:0',
            'vehicle_description' => 'required|string',
            'license_plate' => 'required|string|regex:/^\d{2}[A-Z]{1,2}-\d{3}\.\d{1,2}$/|unique:vehicles,license_plate,' . $request->vehicle_id . ',vehicle_id',
            'rental_price_day' => 'required|integer|min:0',
            'vehicle_status_id' => 'required|integer|exists:vehiclestatus,vehicle_status_id',
            'vehicle_image_name' => 'array|size:3',
            'vehicle_image_name.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        $messages = [
            'required' => ':attribute không được bỏ trống',
            'min' => ':attribute không được nhỏ hơn :min',
            'integer' => ':attribute phải là số',
            'regex' => ':attribute không hợp lệ',
            'size' => ':attribute phải đủ 3 ảnh',
            'unique' => ':attribute đã tồn tại',
        ];

        $attributes = [
            'CarRentalStore_id' => 'Cửa hàng',
            'model_id' => 'Mẫu xe',
            'vehicle_description' => 'Thông tin chi tiết xe',
            'license_plate' => 'Biển số xe',
            'rental_price_day' => 'Số tiền thuê',
            'vehicle_status_id' => 'Trạng thái xe',
            'vehicle_image_name' => 'Hình ảnh xe',
        ];
        $request->validate($rules, $messages, $attributes);

        $vehicle = null;

        if ($request->hasfile('vehicle_image_name')) {
            $images = $request->file('vehicle_image_name');
            
            // dd($images);
            $image_arr = [];
            foreach ($images as $index => $image) {
                $fileName = Str::slug($request->license_plate) . '_' . time() . '.' . $image->getClientOriginalName(). '.' . $image->extension();
    
                // Store the image and retrieve the path
                $image->storeAs('vehicle/images', $fileName, 'public');
                $path = asset('storage/vehicle/images/' . $fileName);
    
        
                $image_arr[] = $path;
            }

            foreach ($image_arr as $index => $path) {
                switch ($index) {
                    case 0:
                        $vehicle_image_data_1 = $path;
                        break;
                    case 1:
                        $vehicle_image_data_2 = $path;
                        break;
                    case 2:
                        $vehicle_image_data_3 = $path;
                        break;
                }
            }


            VehicleImages::where('vehicle_img_id', $request->vehicle_image_id)->update([
                'vehicle_image_data_1' => $vehicle_image_data_1,
                'vehicle_image_data_2' => $vehicle_image_data_2,
                'vehicle_image_data_3' => $vehicle_image_data_3,
            ]);
            Vehicle::where('vehicle_id', $request->vehicle_id)->update([
                'CarRentalStore_id' => $request->CarRentalStore_id,
                'model_id' => $request->model_id,
                'description' => $request->vehicle_description,
                'rental_price_day' => $request->rental_price_day,
                'license_plate' => $request->license_plate,
                'vehicle_image_id' =>$request->vehicle_image_id,
                'vehicle_status_id' => $request->vehicle_status_id,
            ]);
        }else {
            Vehicle::where('vehicle_id', $request->vehicle_id)->update([
                'CarRentalStore_id' => $request->CarRentalStore_id,
                'model_id' => $request->model_id,
                'description' => $request->vehicle_description,
                'rental_price_day' => $request->rental_price_day,
                'license_plate' => $request->license_plate,
                'vehicle_status_id' => $request->vehicle_status_id,
            ]);
            // dd($request->all());
        }

        // $vehicle_id = $request->vehicle_id;
        // $vehicle = vehicle::findOrFail($vehicle_id);

        
        $vehicle = Vehicle::all();
        return response()->json([
            'status' => 'success',
            'vehicle' => $vehicle,
        ]);
    }

    public function delete(Request $request)
    {
        // dd('Xin chào');
        $vehicle_id = $request->vehicle_id;
        $vehicle_image_id = $request->vehicle_image_id;
        if(!$vehicle_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy id của hãng xe'
            ]);
        }

        $vehicle = Vehicle::find($vehicle_id);
        $vehicle_iamges = VehicleImages::find($vehicle_image_id);
        $vehicle_list_count = Vehicle::all()->count();
        if($vehicle) {
            $vehicle->delete();
            $vehicle_iamges->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Xóa thành công hãng xe',
                'vehicle_list_count' => $vehicle_list_count,
            ]);
        }else {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy hãng xe cần xóa'
            ]);
        }

    }


    // return view('admin.vehicle', compact('vehicleList'))->with('i', (request()->input('page', 1) - 1) * 5);

    //Search vehicle
    public function searchvehicle(Request $request) {
        $searchString = $request->search_string_vehicle;

        $vehicleList = DB::table('vehicles')
            ->join('models', 'models.model_id', '=', 'vehicles.model_id')
            ->join('vehiclestatus', 'vehiclestatus.vehicle_status_id', '=', 'vehicles.vehicle_status_id')
            ->join('vehicleimages', 'vehicleimages.vehicle_img_id', '=', 'vehicles.vehicle_image_id')
            ->join('carrentalstore', 'carrentalstore.CarRentalStore_id', '=', 'vehicles.CarRentalStore_id')
            ->join('location', 'location.location_id', '=', 'carrentalstore.Location_id')
            ->select(
                'vehicles.*',
                'vehicles.created_at as vehicle_created_at',
                'vehicles.description as vehicle_description',
                'vehicles.CarRentalStore_id as vehicle_carrentalstore_id',
                'carrentalstore.*',
                'models.*',
                'vehicleimages.*',
                'vehiclestatus.*',
                'location.*',
                DB::raw("CONCAT(models.model_name, ' - ', models.engine_type, ' - ', models.color, ' - ', models.year_of_production) as model_type"),
            )
            ->where(function ($query) use ($searchString) {
                $query->where('vehicles.vehicle_id', 'like', '%'.$searchString.'%')
                    ->orWhere('vehicles.description', 'like', '%'.$searchString.'%')
                    ->orWhere('vehicles.license_plate', 'like', '%'.$searchString.'%')
                    ->orWhere('vehiclestatus.vehicle_status_name', 'like', '%'.$searchString.'%')
                    // Sửa dòng dưới đây:
                    ->orWhereRaw("CONCAT(models.model_name, ' - ', models.engine_type, ' - ', models.color, ' - ', models.year_of_production) like ?", ['%'.$searchString.'%'])
                    ->orWhere('location.unique_location', 'like', '%'. $searchString . '%');
            })
            ->orderBy('vehicles.vehicle_id', 'asc')
            ->paginate(2);


        if($vehicleList->isNotEmpty() > 0) {
            return view('blocks.admin.search_vehicle', compact('vehicleList'))->with('i', (request()->input('page', 1) - 1) * 5)->render();
        }else {
            return response()->json([
                'status' => 'not found',
                'message' => 'Không tìm thấy hãng xe'
            ]);
        }
    }
    

    public function getvehicleStatusId($vehicle_status_name) {
        $vehicle_status_list = config('vehicle_status');
        // dd($vehicle_status_list);

        foreach ($vehicle_status_list as $key => $value) {
            if ($value === $vehicle_status_name) {
                return $key;
            }
        }
    }

    public function showVehicle(Vehicle $vehicle, Request $request)
    {
        $vehicle_information = DB::table('vehicles')
        ->join('vehicleimages', 'vehicles.vehicle_image_id' , '=', 'vehicleimages.vehicle_img_id')
        ->join('vehiclestatus', 'vehiclestatus.vehicle_status_id' , '=', 'vehicles.vehicle_status_id')
        ->join('models', 'models.model_id' , '=', 'vehicles.model_id')
        ->join('carrentalstore as crs1', 'crs1.CarRentalStore_id' , '=', 'vehicles.CarRentalStore_id')
        ->join('location', 'location.location_id' , '=', 'crs1.location_id')
        ->where('vehicle_id', $vehicle->vehicle_id)
        ->select('vehicleimages.*', 'models.*', 'crs1.*', 'vehiclestatus.*', 'vehicles.*', 'location.*')
        ->get();

        $vehicle = $vehicle_information[0];

        return view('clients.vehicle.detail', compact('vehicle'));
    }
}
