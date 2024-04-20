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
                  DB::raw("CONCAT(location.province, ' - ', location.district, ' - ', location.ward, ' - ', location.unique_location) as real_location"))
                  
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
            'province' => 'required',
            'ward' => 'required',
            'district' => 'required',
            'province_id' => 'required|not_in:0',
            'ward_id' => 'required|not_in:0',
            'district_id' => 'required|not_in:0',
            'unique_location' => 'required',
            'phone_number' => 'required|min:10|max:11',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required',
            'branch_id' => 'required|integer|min:1',
        ];

        $messages = [
            'required' => ':attribute không được bỏ trống',
            'phone_number.digits' => ':attribute phải chứa đúng :digits chữ số',
            'avatar.max' => ':attribute có dung lượng tối đa là :max kilobytes.',
            'avatar.mimes' => ':attribute phải là một trong các kiểu file sau: :values.',
            'province_id.not_in' => ':attribute không được bỏ trống',
            'ward_id.not_in' => ':attribute không được bỏ trống',
            'district_id.not_in' => ':attribute không được bỏ trống'
        ];

        $attributes = [
            'province' => 'Tỉnh/Thành phố',
            'district' => 'Quận/huyện',
            'ward' => 'Phường/xã',
            'province_id' => 'Tỉnh/Thành Phố',
            'district_id' => 'Quận/Huyện',
            'ward_id' => 'Phường/Xã',
            'unique_location' => 'Địa chỉ',
            'phone_number' => 'Số điện thoại',
            'avatar' => 'Ảnh cửa hàng',
            'description' => 'Mô tả',
            'branch_id' => 'Chi nhánh',
        ];
        $request->validate($rules, $messages, $attributes);

        // $carRentalStore_id = $request->carRentalStore_id;
        // $carRentalStore = carRentalStore::findOrFail($carRentalStore_id);

        $fileName = "";
        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $fileName = Str::slug($request->input('unique_location')) . '_' . time() . '.' . $request->avatar->extension();
             // Lưu vào thư mục 'public/storage/uploads/carrentalstores'
            $request->avatar->storeAs('uploads/carrentalstores', $fileName, 'public');
        } 

        Location::where('location_id', $request->location_id)->update([
            'province_id' => $request->province_id,
            'district_id' => $request->district_id,
            'ward_id' => $request->ward_id,
            'province' => $request->province,
            'district' => $request->district,
            'ward' => $request->ward,
            'unique_location' => $request->input('unique_location'),
        ]);
        $current_datetime = date('Y-m-d H:i:s');

        $carRentalStore = CarRentalStore::find($request->CarRentalStore_id);
        // dd($carRentalStore);
        $carRentalStore->location_id = $request->location_id;
        $carRentalStore->description = $request->description;
        $carRentalStore->phone_number = $request->phone_number;
        $carRentalStore->branch_id = $request->branch_id;
        if (isset($avatarPath)) {
            $carRentalStore->avatar = $avatarPath;
        }
        $carRentalStore->updated_at = $current_datetime;
        $carRentalStore->save();
    
   

        return response()->json([
            'status' => 'success',
            'message' => 'Cập nhật của hàng thành công',
        ]);
    }

    public function delete(Request $request)
    {
        // dd('Xin chào');
        $carRentalStore_id = $request->CarRentalStore_id;
        $location_id = $request->location_id;

        if(!$carRentalStore_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy id của mẫu xe'
            ]);
        }

        $carRentalStore = CarRentalStore::find($carRentalStore_id);
        $location = Location::find($location_id);
        // dd($location);
        if($carRentalStore && $location) {
            $carRentalStore->delete();
            $location->delete();
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
        $searchString = $request->search_string_carrentalstore;
        
        $carRentalStoreList = CarRentalStore::join('location', 'carrentalstore.location_id', '=', 'location.location_id')
            ->join('branchs', 'carrentalstore.branch_id', '=', 'branchs.branch_id')
            ->where(function($query) use ($searchString) {
                $query->where('carrentalstore.CarRentalStore_id', 'like', '%'.$searchString.'%')
                    ->orWhere('carrentalstore.description', 'like', '%'.$searchString.'%')
                    ->orWhere('carrentalstore.phone_number', 'like', '%'.$searchString.'%')
                    ->orWhere('location.province', 'like', '%'.$searchString.'%')
                    ->orWhere('location.district', 'like', '%'.$searchString.'%')
                    ->orWhere('location.ward', 'like', '%'.$searchString.'%');
            })
            ->orderBy('carrentalstore.carRentalStore_id', 'asc')
            ->select('carrentalstore.*',
                 'location.*',
                 DB::raw("CONCAT(location.province, ' - ', location.district, ' - ', location.ward, ' - ', location.unique_location) as real_location"),
                'branchs.*'  
            )
            ->paginate(5);
    
        // dd($searchString);
    
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
