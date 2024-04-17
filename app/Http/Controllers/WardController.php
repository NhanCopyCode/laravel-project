<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WardController extends Controller
{
    //
    public function getWardByid(Request $request) 
    {
        $district_id = $request->district_id;
        $wards = config('wards');

        $wards = array_filter( $wards['data']['data'], function($ward) use ($district_id) {
            return  $ward['parent_code'] === $district_id;
        });
        
        if($wards) {
            return response()->json([
                'status_code' => 'success',
                'wards' => $wards,
            ]);
        }else {
            return response()->json([
                'status_code' => 'error',
            ]);
        }
    }
}
