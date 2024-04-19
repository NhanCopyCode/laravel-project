<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    //
    public function index()
    {
        $district = config('districts');

        return response()->json([
            'status' => 'success',
            'district' => $district
        ]);
    }
}
