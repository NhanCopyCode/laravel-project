<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\admins\ModelVehicle;
use App\Http\Requests\ModelVehicleRequest;

class ModelController extends Controller
{
    //
    public function index()
    {
        // dd('xin chào');
        $modelList = DB::table('models')
                    ->join('brands', 'models.brand_id', '=', 'brands.brand_id')
                    ->select('models.*', 'brands.brand_name as brand_name') // Lấy tất cả cột từ model_vehicles và cột tên từ brands, đặt là brand_name
                    ->paginate(5);

  
        // dd($modelList);

        return view('admin.model', compact('modelList'))->with('i', (request()->input('page', 1) - 1) * 5);
        // return view('admin.model', compact('modelList'));
    }

    public function addmodel(ModelVehicleRequest $request)
    {

        // dd($this->getmodelStatusId('active') );
        $model = ModelVehicle::create([
            'model_name' => $request->model_name,
            'engine_type' => $request->engine_type,
            'color' => $request->color,
            'year_of_production' => $request->year_of_production,
            'brand_id' => $request->brand_id,
            'model_status_id' => $this->getmodelStatusId('active') //
        ]);

        if($model) {
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
            'model_name' => 'required|unique:models,model_name,'.$request->model_id.',model_id',
            'engine_type' => 'required|integer|min:1',
            'color' => 'required',
            'year_of_production' => 'required|integer|min:1900|max:'.date('Y'),
            'brand_id' => 'required|integer|min:1',
            'model_status_id' => 'required|integer|min:1',
        ];

        $messages = [
            'required' => ':attribute không được để trống',
            'unique' => ':attribute đã tồn tại trong hệ thống',
            'integer' => ':attribute phải là số lớn hơn 0',
            'min' => ':attribute không được bé hơn :min',
            'max' => ':attribute không được lớn hơn :max'
        ];

        $attributes = [
            'model_name' => 'Mẫu xe',
            'engine_type' => 'Dung tích động cơ',
            'color' => 'Màu sắc',
            'year_of_production' => 'Năm sản xuất',
            'brand_id' => 'Hãng xe',
            'model_status_id' => 'Trạng thái'
        ];
        $request->validate($rules, $messages, $attributes);

        // $model_id = $request->model_id;
        // $model = model::findOrFail($model_id);

        ModelVehicle::where('model_id', $request->model_id)->update([
            'model_name' => $request->model_name,
            'engine_type' => $request->engine_type,
            'color' => $request->color,
            'year_of_production' => $request->year_of_production,
            'brand_id' => $request->brand_id,
            'model_status_id' => $request->model_status_id
        ]);

        return response()->json([
            'status' => 'success',
        ]);
    }

    public function delete(Request $request)
    {
        // dd('Xin chào');
        $model_id = $request->model_id;

        if(!$model_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy id của mẫu xe'
            ]);
        }

        $model = ModelVehicle::find($model_id);
        if($model) {
            $model->delete();
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


    // return view('admin.model', compact('modelList'))->with('i', (request()->input('page', 1) - 1) * 5);

    //Search model
    public function searchmodel(Request $request) {
        $modelList = ModelVehicle::join('brands', 'models.brand_id', '=', 'brands.brand_id')
        ->where('models.model_name', 'like', '%'.$request->search_string_model.'%')
        ->orWhere('models.model_id', 'like', '%'.$request->search_string_model.'%')
        ->orWhere('models.engine_type', 'like', '%'.$request->search_string_model.'%')
        ->orWhere('models.color', 'like', '%'.$request->search_string_model.'%')
        ->orWhere('models.year_of_production', 'like', '%'.$request->search_string_model.'%')
        ->orWhere('brands.brand_name', 'like', '%'.$request->search_string_model.'%')
        ->orderBy('models.model_id', 'asc')
        ->select('models.*', 'brands.brand_name as brand_name')
        ->paginate(5);
        // dd($request->search_string_model);
        // dd($modelList);

        if($modelList->count() > 0) {
            return view('blocks.admin.search_model', compact('modelList'))->with('i', (request()->input('page', 1) - 1) * 5)->render();
        }else {
            return response()->json([
                'status' => 'not found',
                'message' => 'Không tìm thấy mẫu xe'
            ]);
        }
    }
    

    public function getmodelStatusId($model_status_name) {
        $model_status_list = config('model_status');
        // dd($model_status_list);

        foreach ($model_status_list as $key => $value) {
            if ($value === $model_status_name) {
                return $key;
            }
        }
    }
}
