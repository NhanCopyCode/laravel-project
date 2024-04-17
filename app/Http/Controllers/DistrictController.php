<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DistrictController extends Controller
{
    //
    public function getDistrictById(Request $request)
    {
        $provine_id  = $request->provine_id;
        $districts = config('districts');

        $districts = array_filter( $districts['data']['data'], function($district) use ($provine_id) {
            return  $district['parent_code'] === $provine_id;
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
            ]);
        }
    }
}
