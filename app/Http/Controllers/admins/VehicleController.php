<?php

namespace App\Http\Controllers\admins;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\VehicleRequest;

class VehicleController extends Controller
{
    //
    public function index()
    {
        // dd('xin chào');
        $vehicleList = Vehicle::paginate(5);

        // dd($vehicleList);
        return view('admin.vehicle', compact('vehicleList'))->with('i', (request()->input('page', 1) - 1) * 5);
        // return view('admin.vehicle', compact('vehicleList'));
    }

    public function addvehicle(VehicleRequest $request)
    {

        $vehicle = Vehicle::create([
            'vehicle_name' => $request->vehicle_name,
            'vehicle_status_id' => $this->getvehicleStatusId('active') //
        ]);

        if($vehicle) {
            return response()->json([
                'status' => 'success',
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

        if(!$vehicle_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy id của hãng xe'
            ]);
        }

        $vehicle = Vehicle::find($vehicle_id);
        if($vehicle) {
            $vehicle->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Xóa thành công hãng xe'
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
