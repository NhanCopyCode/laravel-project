<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CarRentalStore;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CarRentalStoreRequest;

class CarRentalStoreController extends Controller
{
    //
    public function index()
    {
        // dd('xin chào');
        $carRentalStoreList = DB::table('carrentalstore')
        ->join('branchs', 'carrentalstore.branch_id', '=', 'branchs.branch_id')
        ->join('location', 'carrentalstore.location_id', '=', 'location.location_id')
        ->select('carrentalstore.*', 
                 'branchs.branch_name as branch_name', 
                 'location.*',
                  DB::raw("CONCAT(location.province, ' ', location.district, ' ', location.ward) as real_location"))
                  
        ->paginate(2);
        // dd($carRentalStoreList);
        return view('admin.carRentalStore', compact('carRentalStoreList'))->with('i', (request()->input('page', 1) - 1) * 5);
        // return view('admin.carRentalStore', compact('carRentalStoreList'));
    }

    public function addcarRentalStore(CarRentalStoreRequest $request)
    {

         // Try to handle file upload
         if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $fileName = Str::slug($request->input('unique_location')) . '_' . time() . '.' . $request->avatar->extension();
             // Lưu vào thư mục 'public/storage/uploads/carrentalstores'
            $request->avatar->storeAs('uploads/carrentalstores', $fileName, 'public');
        } else {
            // Handle the error if avatar is not uploaded
            return response()->json([
                'status' => 'error',
                'message' => 'There was an error uploading the image.'
            ], 500);
        }
        $location_id = Location::insertGetId([
            'province_id' => $request->province_id,
            'district_id' => $request->district_id,
            'ward_id' => $request->ward_id,
            'province' => $request->input('province'),
            'district' => $request->input('district'),
            'ward' => $request->input('ward'),
            'unique_location' => $request->input('unique_location'),
        ]);

        $carrentalstore = new CarRentalStore([
            'location_id' => $location_id,
            'description' => $request->input('description'),
            'phone_number' => $request->input('phone_number'),
            'branch_id' => (int) $request->input('branch_id'),
            // Save the path to your image here
            'avatar' => 'storage/uploads/carrentalstores/' . $fileName,
        ]);

        $carrentalstore->save(); // Store the data

        return response()->json([
            'status' => 'success',
            'data' => $carrentalstore,
            'message' => 'Cửa hàng đã được thêm thành công.'
        ], 200);
       
    }



    public function update(Request $request)
    {
        // return $request->all();
        $rules = [
            'carRentalStore_name' => 'required|unique:carrentalstore,carRentalStore_name,'.$request->carRentalStore_id.',carRentalStore_id',
            'engine_type' => 'required|integer|min:1',
            'color' => 'required',
            'year_of_production' => 'required|integer|min:1900|max:'.date('Y'),
            'brand_id' => 'required|integer|min:1',
            'carRentalStore_status_id' => 'required|integer|min:1',
        ];

        $messages = [
            'required' => ':attribute không được để trống',
            'unique' => ':attribute đã tồn tại trong hệ thống',
            'integer' => ':attribute phải là số lớn hơn 0',
            'min' => ':attribute không được bé hơn :min',
            'max' => ':attribute không được lớn hơn :max'
        ];

        $attributes = [
            'carRentalStore_name' => 'Mẫu xe',
            'engine_type' => 'Dung tích động cơ',
            'color' => 'Màu sắc',
            'year_of_production' => 'Năm sản xuất',
            'brand_id' => 'Hãng xe',
            'carRentalStore_status_id' => 'Trạng thái'
        ];
        $request->validate($rules, $messages, $attributes);

        // $carRentalStore_id = $request->carRentalStore_id;
        // $carRentalStore = carRentalStore::findOrFail($carRentalStore_id);

        CarRentalStore::where('carRentalStore_id', $request->carRentalStore_id)->update([
            'carRentalStore_name' => $request->carRentalStore_name,
            'engine_type' => $request->engine_type,
            'color' => $request->color,
            'year_of_production' => $request->year_of_production,
            'brand_id' => $request->brand_id,
            'carRentalStore_status_id' => $request->carRentalStore_status_id
        ]);

        return response()->json([
            'status' => 'success',
        ]);
    }

    public function delete(Request $request)
    {
        // dd('Xin chào');
        $carRentalStore_id = $request->carRentalStore_id;

        if(!$carRentalStore_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy id của mẫu xe'
            ]);
        }

        $carRentalStore = CarRentalStore::find($carRentalStore_id);
        if($carRentalStore) {
            $carRentalStore->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Xóa thành công mẫu xe'
            ]);
        }else {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy mẫu xe cần xóa'
            ]);
        }

    }


    // return view('admin.carRentalStore', compact('carRentalStoreList'))->with('i', (request()->input('page', 1) - 1) * 5);

    //Search carRentalStore
    public function searchcarRentalStore(Request $request) {
        $carRentalStoreList = CarRentalStore::join('brands', 'carrentalstore.brand_id', '=', 'brands.brand_id')
        ->where('carrentalstore.carRentalStore_name', 'like', '%'.$request->search_string_carRentalStore.'%')
        ->orWhere('carrentalstore.carRentalStore_id', 'like', '%'.$request->search_string_carRentalStore.'%')
        ->orWhere('carrentalstore.engine_type', 'like', '%'.$request->search_string_carRentalStore.'%')
        ->orWhere('carrentalstore.color', 'like', '%'.$request->search_string_carRentalStore.'%')
        ->orWhere('carrentalstore.year_of_production', 'like', '%'.$request->search_string_carRentalStore.'%')
        ->orWhere('brands.brand_name', 'like', '%'.$request->search_string_carRentalStore.'%')
        ->orderBy('carrentalstore.carRentalStore_id', 'asc')
        ->select('carrentalstore.*', 'brands.brand_name as brand_name')
        ->paginate(5);
        // dd($request->search_string_carRentalStore);
        // dd($carRentalStoreList);

        if($carRentalStoreList->count() > 0) {
            return view('blocks.admin.search_carRentalStore', compact('carRentalStoreList'))->with('i', (request()->input('page', 1) - 1) * 5)->render();
        }else {
            return response()->json([
                'status' => 'not found',
                'message' => 'Không tìm thấy mẫu xe'
            ]);
        }
    }
    

    public function getcarrentalstoretatusId($carRentalStore_status_name) {
        $carRentalStore_status_list = config('carRentalStore_status');
        // dd($carRentalStore_status_list);

        foreach ($carRentalStore_status_list as $key => $value) {
            if ($value === $carRentalStore_status_name) {
                return $key;
            }
        }
    }
}
