<?php

namespace App\Http\Controllers\admins;

use App\Models\Vehicle;
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
                'carrentalstore.*',
                'models.*',
                'vehicleimages.*',
                'vehiclestatus.*',
                'location.*',
                DB::raw("CONCAT(models.model_name, ' - ', models.engine_type, ' - ', models.color, ' - ', models.year_of_production) as model_type"),
            )
            ->paginate(2);

        // $vehicleList = Vehicle::all();
        // dd($vehicleList);
        return view('admin.vehicle', compact('vehicleList'))->with('i', (request()->input('page', 1) - 1) * 5);
        // return view('admin.vehicle', compact('vehicleList'));
    }

    public function addvehicle(VehicleRequest $request)
    {
        // dd($request->CarRentalStore_id);


        if ($request->hasfile('vehicle_image_name')) {
            $images = $request->file('vehicle_image_name');
        
            foreach ($images as $index => $image) {
                // Lưu hình ảnh và lấy đường dẫn
                $name = $image->getClientOriginalName();
                $path =env('APP_URL', 'http://127.0.0.1/:8000/') .$image->storeAs('storage/vehicle/images', $name);
        
               
        
                // Tùy thuộc vào số lượng ảnh và việc lưu chúng vào biến tương ứng
                // Đoạn code này chỉ là ví dụ, cần được điều chỉnh tùy thuộc vào logic cụ thể của bạn.
                if ($index === 0) {
                    $vehicle_image_data_1 = $path;
                } elseif ($index === 1) {
                    $vehicle_image_data_2 = $path;
                } elseif ($index === 2) {
                    $vehicle_image_data_3 = $path;
                }
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
            'vehicle_name' => 'required|unique:vehicles,vehicle_name,'.$request->vehicle_id.',vehicle_id',
            'vehicle_status_id' => 'required',
        ];

        $messages = [
            'required' => ':attribute không được để trống',
            'unique' => ':attribute đã tồn tại trong hệ thống',
        ];

        $attributes = [
            'vehicle_name' => 'Tên hãng xe',
            'vehicle_status_id' => 'Trạng thái hãng xe'
        ];
        $request->validate($rules, $messages, $attributes);

        // $vehicle_id = $request->vehicle_id;
        // $vehicle = vehicle::findOrFail($vehicle_id);

        Vehicle::where('vehicle_id', $request->vehicle_id)->update([
            'vehicle_name' => $request->vehicle_name,
            'vehicle_status_id' => $request->vehicle_status_id
        ]);

        return response()->json([
            'status' => 'success',
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
        $vehicleList = Vehicle::where('vehicle_name', 'like', '%'.$request->search_string_vehicle.'%')
            ->orWhere('vehicle_id', 'like', '%'.$request->search_string_vehicle.'%')
            ->orderBy('vehicle_id', 'asc')
            ->paginate(5);
        
        // dd($request->search_string_vehicle);
        // dd($vehicleList);

        if($vehicleList->count() > 0) {
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
}
