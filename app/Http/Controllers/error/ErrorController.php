<?php

namespace App\Http\Controllers\error;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ErrorController extends Controller
{
    //

    public function error_403()
    {
        return  view('errors.403');
    }
}
