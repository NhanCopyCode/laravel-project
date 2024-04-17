<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProvineController extends Controller
{
    //
    public function index()
    {
        $provines = config('provines');

        return response()->json([
            'provines' => $provines,
            'status_code' => 200,
        ]);
    }

    public function create()
    {

    }

    public function store(Request $request)
    {   
        dd($request->all());
    }

    public function show($id)
    {

    }

    public function edit($id)
    {

    }

    public function update($id, Request $request)
    {
        
    }
}
