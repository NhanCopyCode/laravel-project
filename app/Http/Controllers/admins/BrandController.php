<?php

namespace App\Http\Controllers\admins;

use App\Models\Brand;
use App\Models\Vehicle;
use App\Models\BrandStatus;
use Illuminate\Http\Request;
use App\Http\Requests\BrandRequest;
use App\Models\admins\ModelVehicle;
use App\Http\Controllers\Controller;

class BrandController extends Controller
{
    //
    public function index()
    {
        // dd('xin chào');
        $brandList = Brand::paginate(5);

        // dd($brandList);
        return view('admin.brand', compact('brandList'))->with('i', (request()->input('page', 1) - 1) * 5);
        // return view('admin.brand', compact('brandList'));
    }

    public function addbrand(brandRequest $request)
    {

        $brand = Brand::create([
            'brand_name' => $request->brand_name,
            'brand_status_id' => $this->getbrandStatusId('active') //
        ]);

        if($brand) {
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
            'brand_name' => 'required|unique:brands,brand_name,'.$request->brand_id.',brand_id',
            'brand_status_id' => 'required',
        ];

        $messages = [
            'required' => ':attribute không được để trống',
            'unique' => ':attribute đã tồn tại trong hệ thống',
        ];

        $attributes = [
            'brand_name' => 'Tên hãng xe',
            'brand_status_id' => 'Trạng thái hãng xe'
        ];
        $request->validate($rules, $messages, $attributes);

        // $brand_id = $request->brand_id;
        // $brand = brand::findOrFail($brand_id);

        Brand::where('brand_id', $request->brand_id)->update([
            'brand_name' => $request->brand_name,
            'brand_status_id' => $request->brand_status_id
        ]);

        return response()->json([
            'status' => 'success',
        ]);
    }

    public function delete(Request $request)
    {
        // dd('Xin chào');
        $brand_id = $request->brand_id;

        if(!$brand_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy id của hãng xe'
            ]);
        }

        $brand = Brand::find($brand_id);
        $models = ModelVehicle::where('brand_id', $brand_id)->get();

        $brand_list_number = Brand::all()->count();
        if($brand) {
            $brand->delete();
            foreach ($models as $model) {
                Vehicle::where('model_id', $model->id)->delete();
                $model->delete();
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Xóa thành công hãng xe',
                'brand_list_number' => $brand_list_number
            ]);
        }else {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy hãng xe cần xóa'
            ]);
        }

    }


    // return view('admin.brand', compact('brandList'))->with('i', (request()->input('page', 1) - 1) * 5);

    //Search brand
    public function searchBrand(Request $request) {
        $brandList = Brand::where('brand_name', 'like', '%'.$request->search_string_brand.'%')
            ->orWhere('brand_id', 'like', '%'.$request->search_string_brand.'%')
            ->orderBy('brand_id', 'asc')
            ->paginate(5);
        
        // dd($request->search_string_brand);
        // dd($brandList);

        if($brandList->count() > 0) {
            return view('blocks.admin.search_brand', compact('brandList'))->with('i', (request()->input('page', 1) - 1) * 5)->render();
        }else {
            return response()->json([
                'status' => 'not found',
                'message' => 'Không tìm thấy hãng xe'
            ]);
        }
    }
    

    public function getbrandStatusId($brand_status_name) {
        $brand_status_list = config('brand_status');
        // dd($brand_status_list);

        foreach ($brand_status_list as $key => $value) {
            if ($value === $brand_status_name) {
                return $key;
            }
        }
    }

    
}
