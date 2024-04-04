<?php

namespace App\Http\Controllers\admins;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VehicleController extends Controller
{
    //
    public function index()
    {
        $vehicleList  = Vehicle::all();

        dd($vehicleList);
        return view('admin.vehicle');
    }
}
