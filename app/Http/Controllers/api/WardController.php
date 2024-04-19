<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WardController extends Controller
{
    //
    public function index()
    {
        $wards = config('wards');
        
        return response()->json([
            'status' => 'success',
            'wards' => $wards
        ]);
    }
}
