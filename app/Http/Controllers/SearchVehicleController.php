<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SearchVehicleClient;

class SearchVehicleController extends Controller
{
    //
    public function search_vehicle(SearchVehicleClient $request)
    {   
        dd($request->all());
    }
}
