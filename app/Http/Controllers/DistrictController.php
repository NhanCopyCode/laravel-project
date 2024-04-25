<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DistrictController extends Controller
{
    //
    public function getDistrictById(Request $request)
    {
        $province_id  = $request->province_id;
        $districts = config('districts');

        $districts = array_filter( $districts['data']['data'], function($district) use ($province_id) {
            return  $district['parent_code'] === $province_id;
        });

        if($districts)
        {
            return response()->json([
                'district' => $districts,
                'status_code' => 'success',
            ]);
        }else {
            return response()->json([
                'status_code' => 'error',
                'Lỗi ở file DistrictController' => "error"
            ]);
        }
    }
}
