<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\admins\ModelVehicle;
use App\Http\Requests\ModelVehicleRequest;

class ModelController extends Controller
{
    //
    public function index()
    {
        // dd('xin chào');
        $modelVehicleList = ModelVehicle::paginate(5);

        // dd($branchList);
        return view('admin.branch', compact('modelVehicleList'))->with('i', (request()->input('page', 1) - 1) * 5);
        // return view('admin.branch', compact('branchList'));
    }


    public function addModel(ModelVehicleRequest $request)
    {

        $modelVehicle = ModelVehicle::create([
            'model_name' => $request->model_name,
            'engine_type' => $request->engine_type,
            'color' => $request->color,
            'year_of_production' => $request->year_of_production,
            'brand_id' => $request->brand_id
        ]);

        if($modelVehicle) {
            return response()->json([
                'status' => 'success',
            ]);
        }else {
            return response()->json([
                'status' => 'error',
            ]);
        }
    }
}
